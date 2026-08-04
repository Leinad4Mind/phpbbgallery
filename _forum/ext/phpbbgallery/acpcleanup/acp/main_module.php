<?php
/**
 * phpBB Gallery - ACP CleanUp Extension
 *
 * @package   phpbbgallery/acpcleanup
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\acp;

class main_module
{
	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $auth, $cache, $config, $db, $template, $request, $user, $phpbb_root_path, $phpbb_ext_gallery;

		$user->add_lang_ext('phpbbgallery/core', ['gallery_acp', 'gallery']);
		$user->add_lang_ext('phpbbgallery/acpcleanup', 'info_acp_gallery_cleanup');
		$this->tpl_name = 'gallery_cleanup';

		add_form_key('acp_gallery');

		$submit = $request->is_set_post('submit');

		if ($submit && !check_form_key('acp_gallery'))
		{
			trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		$this->page_title = $user->lang['ACP_GALLERY_CLEANUP'];
		$this->cleanup($submit);
	}

	/**
	 * Cleanup gallery files and database entries
	 *
	 * @param array $missing_entries Files to clean
	 * @param bool $move_to_import Whether to move files to import dir
	 * @return array Messages about cleanup results
	 * @throws \RuntimeException On file operation errors
	 */
	public function cleanup(bool $submit = false): void
	{
		global $auth, $cache, $db, $template, $user, $phpbb_ext_gallery, $table_prefix, $phpbb_container, $request;
		$gallery_config = $phpbb_container->get('phpbbgallery.core.config');
		$action = $request->variable('action', '');
		if ($action === 'migrate_legacy_bbcodes')
		{
			if (!$auth->acl_get('a_gallery_cleanup'))
			{
				trigger_error($user->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$legacy_migrator = $phpbb_container->get('phpbbgallery.acpcleanup.bbcode.legacy_migrator');
			$remaining = $legacy_migrator->count_remaining();
			if ($remaining === 0)
			{
				trigger_error($user->lang('GALLERY_LEGACY_BBCODE_MIGRATE_NONE') . adm_back_link($this->u_action));
			}

			if (confirm_box(true))
			{
				$result = $legacy_migrator->migrate_batch();
				trigger_error($user->lang(
					'GALLERY_LEGACY_BBCODE_MIGRATE_RESULT',
					$result['migrated'],
					$result['failed'],
					$result['remaining']
				) . adm_back_link($this->u_action));
			}

			confirm_box(false, $user->lang(
				'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM',
				$remaining,
				'[' . $gallery_config->get_bbcode_tag() . ']'
			), build_hidden_fields([
				'action' => $action,
			]), 'confirm_body.html', $this->u_action);
			return;
		}

		$delete = $request->is_set_post('delete');
		$prune = $request->is_set_post('prune');
		$cancel = $request->is_set_post('cancel');
		$prune_username_check = $request->is_set_post('prune_username_check');
		$prune_anonymous = $request->is_set_post('prune_anonymous');
		$prune_time_check = $request->is_set_post('prune_time_check');
		$prune_comments_check = $request->is_set_post('prune_comments_check');
		$prune_ratings_check = $request->is_set_post('prune_ratings_check');
		$prune_rating_avg_check = $request->is_set_post('prune_rating_avg_check');

		$missing_sources = $request->variable('source', [0]);
		// basename() strips any directory traversal (../) so these can only ever
		// refer to a bare file inside the gallery upload/import directories below.
		$missing_entries = array_map('basename', $request->variable('entry', [''], true));
		$missing_authors = $request->variable('author', [0], true);
		$missing_comments = $request->variable('comment', [0], true);
		$missing_personals = $request->variable('personal', [0], true);
		$personals_bad = $request->variable('personal_bad', [0], true);
		$prune_pattern = $request->variable('prune_pattern', ['' => ''], true);

		$move_to_import = $request->variable('move_to_import', 0);
		$new_author = $request->variable('new_author', '');

		$gallery_album = $phpbb_container->get('phpbbgallery.core.album');
		$core_cleanup = $phpbb_container->get('phpbbgallery.acpcleanup.cleanup');
		$gallery_auth = $phpbb_container->get('phpbbgallery.core.auth');
		$gallery_url = $phpbb_container->get('phpbbgallery.core.url');

		// Lets detect if ACP Import exists (find if directory is with RW access)
		$acp_import_installed = false;
		$acp_import_dir = $gallery_url->path('import');
		if (file_exists($acp_import_dir) && is_writable($acp_import_dir))
		{
			$acp_import_installed = true;
		}
		if ($prune && empty($prune_pattern))
		{
			$prune_pattern['image_album_id'] = implode(',', $request->variable('prune_album_ids', [0]));
			if ($prune_username_check)
			{
				$usernames = $request->variable('prune_usernames', '', true);
				$usernames = explode("\n", $usernames);
				$prune_pattern['image_user_id'] = [];
				if (!empty($usernames))
				{
					if (!function_exists('user_get_id_name'))
					{
						$gallery_url->_include('functions_user', 'phpbb');
					}
					user_get_id_name($user_ids, $usernames);
					$prune_pattern['image_user_id'] = $user_ids;
				}
				if ($prune_anonymous)
				{
					$prune_pattern['image_user_id'][] = ANONYMOUS;
				}
				$prune_pattern['image_user_id'] = implode(',', $prune_pattern['image_user_id']);
			}
			if ($prune_time_check)
			{
				$prune_time = explode('-', $request->variable('prune_time', ''));

				if (sizeof($prune_time) == 3)
				{
					$prune_pattern['image_time'] = @gmmktime(0, 0, 0, (int) $prune_time[1], (int) $prune_time[2], (int) $prune_time[0]);
				}
			}
			if ($prune_comments_check)
			{
				$prune_pattern['image_comments'] = $request->variable('prune_comments', 0);
			}
			if ($prune_ratings_check)
			{
				$prune_pattern['image_rates'] = $request->variable('prune_ratings', 0);
			}
			if ($prune_rating_avg_check)
			{
				$prune_pattern['image_rate_avg'] = (int) ($request->variable('prune_rating_avg', 0.0) * 100);
			}
		}

		$s_hidden_fields = build_hidden_fields([
			'source'		=> $missing_sources,
			'entry'			=> $missing_entries,
			'author'		=> $missing_authors,
			'comment'		=> $missing_comments,
			'personal'		=> $missing_personals,
			'personal_bad'	=> $personals_bad,
			'prune_pattern'	=> $prune_pattern,
			'move_to_import'	=> $move_to_import,
		]);

		if ($submit)
		{
			$user_id = 1;
			if ($new_author)
			{
				$user_id = 0;
				if (!function_exists('user_get_id_name'))
				{
					$gallery_url->_include('functions_user', 'phpbb');
				}
				user_get_id_name($user_id, $new_author);
				if (is_array($user_id) && !empty($user_id))
				{
					$user_id = $user_id[0];
				}
				if (!$user_id)
				{
					trigger_error($user->lang('CLEAN_USER_NOT_FOUND', $new_author) . adm_back_link($this->u_action), E_USER_WARNING);
				}
			}
			if ($missing_authors)
			{
				$sql = 'UPDATE ' . $table_prefix . 'gallery_images
					SET image_user_id = ' . $user_id . ",
						image_user_colour = ''
					WHERE " . $db->sql_in_set('image_id', $missing_authors);
				$db->sql_query($sql);
			}
			if ($missing_comments)
			{
				$sql = 'UPDATE ' . $table_prefix . 'gallery_comments
					SET comment_user_id = ' . $user_id . ",
						comment_user_colour = ''
					WHERE " . $db->sql_in_set('comment_id', $missing_comments);
				$db->sql_query($sql);
			}
			trigger_error($user->lang['CLEAN_CHANGED'] . adm_back_link($this->u_action));
		}

		if (confirm_box(true))
		{
			$message = [];
			if ($missing_entries)
			{
				if ($acp_import_installed && $move_to_import)
				{
					foreach ($missing_entries as $entry)
					{
						copy($gallery_url->path('upload') . '/' . $entry, $gallery_url->path('import') . '/' . $entry);
					}
				}
				$message[] = $core_cleanup->delete_files($missing_entries);
			}
			if ($missing_sources)
			{
				$message[] = $core_cleanup->delete_images($missing_sources);
			}
			if ($missing_authors)
			{
				$message[] = $core_cleanup->delete_author_images($missing_authors);
			}
			if ($missing_comments)
			{
				$message[] = $core_cleanup->delete_author_comments($missing_comments);
			}
			if ($missing_personals || $personals_bad)
			{
				$message = array_merge($message, $core_cleanup->delete_pegas($personals_bad, $missing_personals));

				// Only do this, when we changed something about the albums
				$cache->destroy('_albums');
				$gallery_auth->set_user_permissions('all', '');
			}
			if ($prune_pattern)
			{
				$message[] = $core_cleanup->prune($prune_pattern);
			}

			if (empty($message))
			{
				trigger_error($user->lang['CLEAN_NO_ACTION'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Make sure the overall image & comment count is correct...
			$sql = 'SELECT COUNT(image_id) AS num_images, SUM(image_comments) AS num_comments
				FROM ' . $table_prefix . 'gallery_images
				WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
					AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
					AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$gallery_config->set('num_images', $row['num_images']);
			$gallery_config->set('num_comments', (int) $row['num_comments']);

			/**
			* Event to let add-ons repair their own counters once the gallery
			* has been cleaned up
			*
			* @event phpbbgallery.acpcleanup.cleanup_finished
			* @var	array	message		Language keys describing what was cleaned
			* @since 1.3.0
			*/
			$vars = ['message'];
			extract($phpbb_container->get('dispatcher')->trigger_event('phpbbgallery.acpcleanup.cleanup_finished', compact($vars)));

			$cache->destroy('sql', $table_prefix . 'gallery_albums');
			$cache->destroy('sql', $table_prefix . 'gallery_comments');
			$cache->destroy('sql', $table_prefix . 'gallery_images');
			$cache->destroy('sql', $table_prefix . 'gallery_rates');
			$cache->destroy('sql', $table_prefix . 'gallery_reports');
			$cache->destroy('sql', $table_prefix . 'gallery_watch');

			$message_string = '';
			foreach ($message as $lang_key)
			{
				$message_string .= (($message_string) ? '<br />' : '') . $user->lang[$lang_key];
			}

			trigger_error($message_string . adm_back_link($this->u_action));
		}
		else if ($delete || $prune || $cancel)
		{
			if ($cancel)
			{
				trigger_error($user->lang['CLEAN_GALLERY_ABORT'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
			else
			{
				$clean_gallery_confirm = $user->lang['CONFIRM_CLEAN'];
				if ($missing_sources)
				{
					$clean_gallery_confirm = $user->lang['CONFIRM_CLEAN_SOURCES'] . '<br />' . $clean_gallery_confirm;
				}
				if ($missing_entries)
				{
					$clean_gallery_confirm = $user->lang['CONFIRM_CLEAN_ENTRIES'] . '<br />' . $clean_gallery_confirm;
				}
				if ($missing_authors)
				{
					$clean_gallery_confirm = $user->lang['CONFIRM_CLEAN_AUTHORS'] . '<br />' . $clean_gallery_confirm;
				}
				if ($missing_comments)
				{
					$clean_gallery_confirm = $user->lang['CONFIRM_CLEAN_COMMENTS'] . '<br />' . $clean_gallery_confirm;
				}
				if ($personals_bad || $missing_personals)
				{
					$personals_bad_names = [];
					$missing_personals_names = [];
					$sql = 'SELECT album_name, album_user_id
						FROM ' . $table_prefix . 'gallery_albums
						WHERE ' . $db->sql_in_set('album_user_id', array_merge($missing_personals, $personals_bad));
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						if (in_array($row['album_user_id'], $personals_bad))
						{
							$personals_bad_names[] = $row['album_name'];
						}
						else
						{
							$missing_personals_names[] = $row['album_name'];
						}
					}
					$db->sql_freeresult($result);
				}
				if ($missing_personals)
				{
					$clean_gallery_confirm = $user->lang('CONFIRM_CLEAN_PERSONALS', implode(', ', $missing_personals_names)) . '<br />' . $clean_gallery_confirm;
				}
				if ($personals_bad)
				{
					$clean_gallery_confirm = $user->lang('CONFIRM_CLEAN_PERSONALS_BAD', implode(', ', $personals_bad_names)) . '<br />' . $clean_gallery_confirm;
				}
				if ($prune && empty($prune_pattern))
				{
					trigger_error($user->lang['CLEAN_PRUNE_NO_PATTERN'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				else if ($prune && $prune_pattern)
				{
					$clean_gallery_confirm = $user->lang('CONFIRM_PRUNE', $core_cleanup->lang_prune_pattern($prune_pattern)) . '<br />' . $clean_gallery_confirm;
				}
				confirm_box(false, $clean_gallery_confirm, $s_hidden_fields, 'confirm_body.html', $this->u_action);
			}
		}

		$requested_source = [];
		$sql_array = [
			'SELECT'		=> 'i.image_id, i.image_name, i.image_filemissing, i.image_filename, i.image_username, u.user_id',
			'FROM'			=> [$table_prefix . 'gallery_images' => 'i'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [USERS_TABLE => 'u'],
					'ON'		=> 'u.user_id = i.image_user_id',
				],
			],
		];
		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['image_filemissing'])
			{
				$template->assign_block_vars('sourcerow', [
					'IMAGE_ID'		=> $row['image_id'],
					'IMAGE_NAME'	=> $row['image_name'],
				]);
			}
			if (!$row['user_id'])
			{
				$template->assign_block_vars('authorrow', [
					'IMAGE_ID'		=> $row['image_id'],
					'AUTHOR_NAME'	=> $row['image_username'],
				]);
			}
			$requested_source[] = $row['image_filename'];
		}
		$db->sql_freeresult($result);

		$check_mode = $request->variable('check_mode', '');
		if ($check_mode == 'source')
		{
			$source_missing = [];

			// Reset the status: a image might have been viewed without file but the file is back
			$sql = 'UPDATE ' . $table_prefix . 'gallery_images
				SET image_filemissing = 0';
			$db->sql_query($sql);

			$sql = 'SELECT image_id, image_filename, image_filemissing
				FROM ' . $table_prefix . 'gallery_images';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				if (!file_exists($gallery_url->path('upload') . $row['image_filename']))
				{
					$source_missing[] = $row['image_id'];
				}
			}
			$db->sql_freeresult($result);

			if ($source_missing)
			{
				$sql = 'UPDATE ' . $table_prefix . 'gallery_images
					SET image_filemissing = 1
					WHERE ' . $db->sql_in_set('image_id', $source_missing);
				$db->sql_query($sql);
			}
		}

		if ($check_mode == 'entry')
		{
			$directory = $gallery_url->path('upload');
			$handle = @opendir($directory);
			while ($handle !== false && ($file = readdir($handle)) !== false)
			{
				if (!is_dir($directory . $file) &&
				 ((substr(strtolower($file), '-5') == '.webp') || (substr(strtolower($file), '-4') == '.png') || (substr(strtolower($file), '-4') == '.gif') || (substr(strtolower($file), '-4') == '.jpg') || (substr(strtolower($file), '-5') == '.jpeg')) &&
				 ((substr(strtolower($file), '-8') <> '_wm.webp') && (substr(strtolower($file), '-7') <> '_wm.png') && (substr(strtolower($file), '-7') <> '_wm.gif') && (substr(strtolower($file), '-7') <> '_wm.jpg') && (substr(strtolower($file), '-8') <> '_wm.jpeg'))
				 && !in_array($file, $requested_source)
				)
				{
					if ((strpos($file, 'image_not_exist') !== false) || (strpos($file, 'not_authorised') !== false) || (strpos($file, 'no_hotlinking') !== false))
					{
						continue;
					}

					$encoding = mb_detect_encoding($file, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
					$template->assign_block_vars('entryrow', [
						'FILE_NAME'				=> $encoding === 'UTF-8' ? $file : mb_convert_encoding($file, 'UTF-8', $encoding ?: 'Windows-1252'),
					]);
				}
			}
			if ($handle !== false)
			{
				closedir($handle);
			}
		}

		$sql_array = [
			'SELECT'		=> 'c.comment_id, c.comment_image_id, c.comment_username, u.user_id',
			'FROM'			=> [$table_prefix . 'gallery_comments' => 'c'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [USERS_TABLE => 'u'],
					'ON'		=> 'u.user_id = c.comment_user_id',
				],
			],
		];
		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			if (!$row['user_id'])
			{
				$template->assign_block_vars('commentrow', [
					'COMMENT_ID'	=> $row['comment_id'],
					'IMAGE_ID'		=> $row['comment_image_id'],
					'AUTHOR_NAME'	=> $row['comment_username'],
				]);
			}
		}
		$db->sql_freeresult($result);

		$sql_array = [
			'SELECT'		=> 'a.album_id, a.album_user_id, a.album_name, u.user_id, a.album_images_real',
			'FROM'			=> [$table_prefix . 'gallery_albums' => 'a'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [USERS_TABLE => 'u'],
					'ON'		=> 'u.user_id = a.album_user_id',
				],
			],

			'WHERE'			=> 'a.album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . ' AND a.parent_id = 0',
		];
		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query($sql);
		$personalrow = $personal_bad_row = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$album = [
				'user_id'		=> $row['album_user_id'],
				'album_id'		=> $row['album_id'],
				'album_name'	=> $row['album_name'],
				'images'		=> $row['album_images_real'],
			];
			if (!$row['user_id'])
			{
				$personalrow[$row['album_user_id']] = $album;
			}
			$personal_bad_row[$row['album_user_id']] = $album;
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT ga.album_user_id, ga.album_images_real
			FROM ' . $table_prefix . 'gallery_albums ga
			WHERE ga.album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . '
				AND ga.parent_id <> 0';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			if (isset($personalrow[$row['album_user_id']]))
			{
				$personalrow[$row['album_user_id']]['images'] = $personalrow[$row['album_user_id']]['images'] + $row['album_images_real'];
			}
			if (isset($personal_bad_row[$row['album_user_id']]))
			{
				$personal_bad_row[$row['album_user_id']]['images'] += $row['album_images_real'];
			}
		}
		$db->sql_freeresult($result);

		foreach ($personalrow as $key => $row)
		{
			$template->assign_block_vars('personalrow', [
				'USER_ID'		=> $row['user_id'],
				'ALBUM_ID'		=> $row['album_id'],
				'AUTHOR_NAME'	=> $row['album_name'],
			]);
		}
		foreach ($personal_bad_row as $key => $row)
		{
			$template->assign_block_vars('personal_bad_row', [
				'USER_ID'		=> $row['user_id'],
				'ALBUM_ID'		=> $row['album_id'],
				'AUTHOR_NAME'	=> $row['album_name'],
				'IMAGES'		=> $row['images'],
			]);
		}

		$template->assign_vars([
			'S_GALLERY_MANAGE_RESTS'		=> true,
			'ACP_GALLERY_TITLE'				=> $user->lang['ACP_GALLERY_CLEANUP'],
			'ACP_GALLERY_TITLE_EXPLAIN'		=> $user->lang['ACP_GALLERY_CLEANUP_EXPLAIN'],
			'ACP_IMPORT_INSTALLED'	=> $acp_import_installed,
			'CHECK_SOURCE'			=> $this->u_action . '&amp;check_mode=source',
			'CHECK_ENTRY'			=> $this->u_action . '&amp;check_mode=entry',

			'U_FIND_USERNAME'		=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=acp_gallery&amp;field=prune_usernames'),
			'S_SELECT_ALBUM'		=> $gallery_album->get_albumbox(false, '', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),

			'S_FOUNDER'				=> ($user->data['user_type'] == USER_FOUNDER) ? true : false,
			'ACTIVE_BBCODE_TAG'		=> '[' . $gallery_config->get_bbcode_tag() . ']',
		]);
	}
}
