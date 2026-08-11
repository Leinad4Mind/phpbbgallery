<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\ucp;

/**
* @package ucp
*/
class main_module
{
	public string $u_action = '';
	protected \phpbb\language\language $language;
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $user, $phpbb_container, $table_prefix, $phpbb_gallery_url;
		global $phpbb_ext_gallery_core_album, $albums_table, $phpbb_ext_gallery_core_auth, $phpbb_ext_gallery_core_album_display, $images_table;
		global $phpbb_gallery_image, $users_table, $phpbb_ext_gallery_config, $comments_table, $rates_table, $reports_table, $watch_table, $tracking_table;
		global $phpbb_ext_gallery_user, $request;

		$phpbb_gallery_url = $phpbb_container->get('phpbbgallery.core.url');
		$phpbb_gallery_url->_include('functions_display', 'phpbb');

		$phpbb_ext_gallery_core_album =$phpbb_container->get('phpbbgallery.core.album');

		$phpbb_ext_gallery_core_auth = $phpbb_container->get('phpbbgallery.core.auth');

		$phpbb_ext_gallery_config = $phpbb_container->get('phpbbgallery.core.config');

		$phpbb_ext_gallery_core_album_display = $phpbb_container->get('phpbbgallery.core.album.display');

		$phpbb_gallery_image = $phpbb_container->get('phpbbgallery.core.image');

		$phpbb_ext_gallery_user = $phpbb_container->get('phpbbgallery.core.user');
		$this->language = $phpbb_container->get('language');

		$albums_table = $table_prefix . 'gallery_albums';
		$roles_table = $table_prefix . 'gallery_roles';
		$permissions_table = $table_prefix . 'gallery_permissions';
		$modscache_table = $table_prefix . 'gallery_modscache';
		$users_table = $table_prefix . 'gallery_users';
		$images_table = $table_prefix . 'gallery_images';
		$comments_table = $table_prefix . 'gallery_comments';
		$rates_table = $table_prefix . 'gallery_rates';
		$reports_table = $table_prefix . 'gallery_reports';
		$watch_table = $table_prefix . 'gallery_watch';
		$tracking_table = $table_prefix . 'gallery_albums_track';

		$this->language->add_lang(['gallery', 'gallery_acp', 'gallery_mcp', 'gallery_ucp'], 'phpbbgallery/core');
		$this->language->add_lang('posting');
		$this->tpl_name = 'gallery/ucp_gallery';
		add_form_key('ucp_gallery');

		$mode = $request->variable('mode', 'manage_albums');
		$this->u_action = $this->build_ucp_action($phpbb_gallery_url, $id, $mode);
		$action = $request->variable('action', '');
		$cancel = $request->is_set_post('cancel');
		$phpbb_ext_gallery_core_auth->load_user_permissions($user->data['user_id']);
		if ($cancel)
		{
			$action = '';
		}
		switch ($mode)
		{
			case 'manage_albums':
				switch ($action)
				{
					case 'manage':
						$title = 'MANAGE_SUBALBUMS';
						$this->page_title = $this->language->lang($title);
						$this->manage_albums();
					break;

					case 'create':
						$title = 'CREATE_SUBALBUM';
						$this->page_title = $this->language->lang($title);
						$this->create_album();
					break;

					case 'edit':
						$title = 'EDIT_SUBALBUM';
						$this->page_title = $this->language->lang($title);
						$this->edit_album();
					break;

					case 'delete':
						$title = 'DELETE_ALBUM';
						$this->page_title = $this->language->lang($title);
						$this->delete_album();
					break;

					case 'move':
						$this->move_album();
					break;

					case 'initialise':
						$this->initialise_album();
					break;

					default:
						$title = 'UCP_GALLERY_PERSONAL_ALBUMS';
						$this->page_title = $this->language->lang($title);
						if (!$phpbb_ext_gallery_user->get_data('personal_album_id'))
						{
							$this->info();
						}
						else
						{
							$this->manage_albums();
						}
					break;
				}
			break;

			case 'manage_subscriptions':
				$title = 'UCP_GALLERY_WATCH';
				$this->page_title = $this->language->lang($title);
				$this->manage_subscriptions();
			break;
		}
	}

	public function info(): void
	{
		global $template, $user, $phpbb_ext_gallery_user, $phpbb_gallery_url, $phpbb_container;
		$this->language = $phpbb_container->get('language');

		//We need to set user_ID so we can test for any other thing
		$phpbb_ext_gallery_user->set_user_id($user->data['user_id']);
		if (!$phpbb_ext_gallery_user->get_data('personal_album_id'))
		{
			// User will probably go to initialise_album()
			$template->assign_vars([
				'S_INFO_CREATE'				=> true,
				'S_UCP_ACTION'		=> $this->u_action . '&amp;action=initialise',

				'L_TITLE'			=> $this->language->lang('UCP_GALLERY_PERSONAL_ALBUMS'),
				'L_TITLE_EXPLAIN'	=> $this->language->lang('NO_PERSONAL_ALBUM'),
			]);
		}
		else
		{
			$phpbb_gallery_url->redirect('phpbb', 'ucp', 'i=-phpbbgallery-core-ucp-main_module&mode=manage_albums&action=manage');
		}
	}

	public function initialise_album(): void
	{
		global $cache, $db,  $user, $phpbb_ext_gallery_core_auth, $phpbb_ext_gallery_core_album, $phpbb_ext_gallery_config, $albums_table, $phpbb_ext_gallery_user;
		global $request, $users_table, $phpbb_container;

		if (!$this->is_valid_form_submission($request, 'submit'))
		{
			trigger_error('FORM_INVALID');
		}

		// we will have to initialise $phpbb_ext_gallery_user
		$phpbb_ext_gallery_user->set_user_id($user->data['user_id']);
		if (!$phpbb_ext_gallery_user->get_data('personal_album_id'))
		{
			// Check if the user is allowed to have on
			if (!$phpbb_ext_gallery_core_auth->acl_check('i_upload', $phpbb_ext_gallery_core_auth::OWN_ALBUM))
			{
				trigger_error('NO_PERSALBUM_ALLOWED');
			}

			$album_data = [
				'album_name'					=> $user->data['username'],
				'parent_id'						=> 0,
				//left_id and right_id default by db
				'album_desc_options'			=> 7,
				'album_desc'					=> utf8_normalize_nfc($request->variable('album_desc', '', true)),
				'album_parents'					=> '',
				'album_type'					=> (int) \phpbbgallery\core\block::TYPE_UPLOAD,
				'album_status'					=> (int) \phpbbgallery\core\block::ALBUM_OPEN,
				'album_user_id'					=> $user->data['user_id'],
				'album_last_username'			=> '',
				'album_last_user_colour'		=> $user->data['user_colour'],
			];
			$db->sql_query('INSERT INTO ' . $albums_table . ' ' . $db->sql_build_array('INSERT', $album_data));
			$album_id = $db->sql_nextid();

			$phpbb_ext_gallery_user->update_data([
				'personal_album_id'	=> $album_id,
			]);

			$this->subscribe_pegas($album_id);
			$phpbb_ext_gallery_config->inc('num_pegas', 1);

			// Update the config for the statistic on the index
			$phpbb_ext_gallery_config->set('newest_pega_user_id', $user->data['user_id']);
			$phpbb_ext_gallery_config->set('newest_pega_username', $user->data['username']);
			$phpbb_ext_gallery_config->set('newest_pega_user_colour', $user->data['user_colour']);
			$phpbb_ext_gallery_config->set('newest_pega_album_id', $album_id);

			$cache->destroy('_albums');
			$cache->destroy('sql', $albums_table);
			$cache->destroy('sql', $users_table);
			$phpbb_ext_gallery_core_auth->set_user_permissions('all', '');
		}
		redirect($this->u_action);
	}

	public function manage_albums(): void
	{
		global $cache, $db, $template, $user, $phpbb_ext_gallery_core_album, $albums_table, $phpbb_ext_gallery_core_auth, $phpbb_ext_gallery_core_album_display;
		global $phpbb_container, $request, $phpbb_gallery_url, $phpbb_ext_gallery_user;

		$parent_id = $request->variable('parent_id', $phpbb_ext_gallery_user->get_data('personal_album_id'));
		$phpbb_ext_gallery_core_album->check_user($parent_id);
		$helper = $phpbb_container->get('controller.helper');
		$this->language = $phpbb_container->get('language');

		$sql = 'SELECT COUNT(album_id) albums
			FROM ' . $albums_table . '
			WHERE album_user_id = ' . (int) $user->data['user_id'];
		$result = $db->sql_query($sql);
		$albums = (int) $db->sql_fetchfield('albums');
		$db->sql_freeresult($result);

		$s_allowed_create = ($phpbb_ext_gallery_core_auth->acl_check('a_unlimited', $phpbb_ext_gallery_core_auth::OWN_ALBUM) || ($phpbb_ext_gallery_core_auth->acl_check('a_count', $phpbb_ext_gallery_core_auth::OWN_ALBUM) > $albums)) ? true : false;
		$template->assign_vars([
			'S_MANAGE_SUBALBUMS'			=> true,
			'S_UCP_ACTION'					=> $this->u_action,
			'U_CREATE_SUBALBUM'				=> ($s_allowed_create) ? ($this->u_action . '&amp;action=create' . (($parent_id) ? '&amp;parent_id=' . $parent_id : '')) : '',

			'L_TITLE'			=> $this->language->lang('MANAGE_SUBALBUMS'),
			//'ACP_GALLERY_TITLE_EXPLAIN'	=> $user->lang['ALBUM'],
		]);

		if (!$parent_id)
		{
			$navigation = $this->language->lang('PERSONAL_ALBUM');
		}
		else
		{
			$navigation = $this->language->lang('PERSONAL_ALBUM');

			$albums_nav = $phpbb_ext_gallery_core_album_display->get_branch($user->data['user_id'], $parent_id, 'parents', 'descending');
			foreach ($albums_nav as $row)
			{
				if ($row['album_id'] == $parent_id)
				{
					$navigation .= ' &raquo; ' . $row['album_name'];
				}
				else
				{
					$navigation .= ' &raquo; <a href="' . $this->u_action . '&amp;action=manage&amp;parent_id=' . $row['album_id'] . '">' . $row['album_name'] . '</a>';
				}
			}
		}

		$album = [];
		$sql = 'SELECT *
			FROM ' . $albums_table . '
			WHERE parent_id = ' . (int) $parent_id . '
				AND album_user_id = ' . (int) $user->data['user_id'] . '
			ORDER BY left_id ASC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$album[] = $row;
		}
		$db->sql_freeresult($result);

		for ($i = 0, $end = count($album); $i < $end; $i++)
		{
			$folder_img = ($album[$i]['left_id'] + 1 != $album[$i]['right_id']) ? 'forum_read_subforum' : 'forum_read';
			$template->assign_block_vars('album_row', [
				'FOLDER_IMAGE'			=> $user->img($folder_img, $album[$i]['album_name'], false, '', 'src'),
				'U_ALBUM'				=> $this->u_action . '&amp;action=manage&amp;parent_id=' . $album[$i]['album_id'],
				'ALBUM_ID'				=> (int) $album[$i]['album_id'],
				'ALBUM_NAME'			=> $album[$i]['album_name'],
				'ALBUM_DESCRIPTION'		=> generate_text_for_display($album[$i]['album_desc'], $album[$i]['album_desc_uid'], $album[$i]['album_desc_bitfield'], $album[$i]['album_desc_options']),
				'U_EDIT'				=> $this->u_action . '&amp;action=edit&amp;album_id=' . $album[$i]['album_id'],
				'U_DELETE'				=> $this->u_action . '&amp;action=delete&amp;album_id=' . $album[$i]['album_id'],
			]);
		}

		$template->assign_vars([
			'NAVIGATION'		=> $navigation,
			'S_ALBUM'			=> $parent_id,
			'U_GOTO'			=> $helper->route('phpbbgallery_core_album', ['album_id' => $parent_id]),
			'U_EDIT'			=> $this->u_action . '&amp;action=edit&amp;album_id=' . $parent_id,
			'U_DELETE'			=> $this->u_action . '&amp;action=delete&amp;album_id=' . $parent_id,
			'U_UPLOAD'			=> $helper->route('phpbbgallery_core_album_upload', ['album_id' => $parent_id]),
			'ICON_MOVE_DOWN'			=> '<img src="' . $phpbb_gallery_url->path('images') . 'icon_down.gif" alt="" />',
			'ICON_MOVE_DOWN_DISABLED'	=> '<img src="' . $phpbb_gallery_url->path('images') . 'icon_down_disabled.gif" alt="" />',
			'ICON_MOVE_UP'				=> '<img src="' . $phpbb_gallery_url->path('images') . 'icon_up.gif" alt="" />',
			'ICON_MOVE_UP_DISABLED'		=> '<img src="' . $phpbb_gallery_url->path('images') . 'icon_up_disabled.gif" alt="" />',
			'ICON_EDIT'					=> '<img src="' . $phpbb_gallery_url->path('images') . 'icon_edit.gif" alt="" />',
			'ICON_DELETE'				=> '<img src="' . $phpbb_gallery_url->path('images') . 'icon_delete.gif" alt="" />',
		]);
	}

	public function create_album(): void
	{
		global $cache, $db, $template, $user, $phpbb_gallery_url, $phpbb_ext_gallery_core_auth, $albums_table, $phpbb_ext_gallery_core_album, $request;
		global $phpbb_container, $phpbb_ext_gallery_user, $users_table;
		$phpbb_gallery_url->_include(['bbcode', 'message_parser'], 'phpbb');
		$this->language = $phpbb_container->get('language');

		// Check if the user has already reached his limit
		if (!$phpbb_ext_gallery_core_auth->acl_check('i_upload', $phpbb_ext_gallery_core_auth::OWN_ALBUM))
		{
			trigger_error('NO_PERSALBUM_ALLOWED');
		}

		$sql = 'SELECT COUNT(album_id) albums
			FROM ' . $albums_table . '
			WHERE album_user_id = ' . (int) $user->data['user_id'];
		$result = $db->sql_query($sql);
		$albums = $db->sql_fetchfield('albums');
		$db->sql_freeresult($result);

		if (!$phpbb_ext_gallery_core_auth->acl_check('a_unlimited', $phpbb_ext_gallery_core_auth::OWN_ALBUM) && ($phpbb_ext_gallery_core_auth->acl_check('a_count', $phpbb_ext_gallery_core_auth::OWN_ALBUM) <= $albums))
		{
			trigger_error('NO_MORE_SUBALBUMS_ALLOWED');
		}

		$submit = $request->is_set_post('submit');
		$redirect = $request->variable('redirect', '');

		if (!$submit)
		{
			$parent_id = $request->variable('parent_id', 0);
			$phpbb_ext_gallery_core_album->check_user($parent_id);
			$parents_list = $phpbb_ext_gallery_core_album->get_albumbox(false, '', $parent_id, false, false, $user->data['user_id']);

			$s_access_options = '';
			if ($phpbb_ext_gallery_core_auth->acl_check('a_restrict', $phpbb_ext_gallery_core_auth::OWN_ALBUM))
			{
				$access_options = [
					$phpbb_ext_gallery_core_auth::ACCESS_ALL			=> 'ALL',
					$phpbb_ext_gallery_core_auth::ACCESS_REGISTERED	=> 'REGISTERED',
					$phpbb_ext_gallery_core_auth::ACCESS_NOT_FOES		=> 'NOT_FOES',
					$phpbb_ext_gallery_core_auth::ACCESS_FRIENDS		=> 'FRIENDS',
				];
				foreach ($access_options as $value => $lang_key)
				{
					$s_access_options .= '<option value="' . $value . '">' . $this->language->lang('ACCESS_CONTROL_' . $lang_key) . '</option>';
				}
			}

			$template->assign_vars([
				'S_CREATE_SUBALBUM'		=> true,
				'S_UCP_ACTION'			=> $this->u_action . '&amp;action=create' . (($redirect != '') ? '&amp;redirect=album' : ''),
				'L_TITLE'				=> $this->language->lang('CREATE_SUBALBUM'),
				'L_TITLE_EXPLAIN'		=> $this->language->lang('CREATE_SUBALBUM_EXP'),

				'S_DESC_BBCODE_CHECKED'		=> true,
				'S_DESC_SMILIES_CHECKED'	=> true,
				'S_DESC_URLS_CHECKED'		=> true,
				'S_PARENT_OPTIONS'			=> '<option value="' . $phpbb_ext_gallery_user->get_data('personal_album_id') . '">' . $this->language->lang('NO_PARENT_ALBUM') . '</option>' . $parents_list,

				'S_AUTH_ACCESS_OPTIONS'		=> $s_access_options,
				'L_ALBUM_ACCESS_EXPLAIN'	=> $this->language->lang('ALBUM_ACCESS_EXPLAIN', '<a href="' . $phpbb_gallery_url->append_sid('phpbb', 'faq') . '#f6r0">', '</a>'),
			]);
		}
		else
		{
			if (!check_form_key('ucp_gallery'))
			{
				trigger_error('FORM_INVALID');
			}

			// Create the subalbum
			$album_data = [
				'album_name'					=> $request->variable('album_name', '', true),
				'parent_id'						=> $request->variable('parent_id', 0),
				'album_parents'					=> '',
				'album_type'					=> (int) \phpbbgallery\core\block::TYPE_UPLOAD,
				'album_status'					=> (int) \phpbbgallery\core\block::ALBUM_OPEN,
				'album_desc_options'			=> 7,
				'album_desc'					=> utf8_normalize_nfc($request->variable('album_desc', '', true)),
				'album_user_id'					=> $user->data['user_id'],
				'album_last_username'			=> '',
				'album_auth_access'				=> ($phpbb_ext_gallery_core_auth->acl_check('a_restrict', $phpbb_ext_gallery_core_auth::OWN_ALBUM)) ? $request->variable('album_auth_access', 0) : 0,
			];

			$album_data['album_auth_access'] = min(3, max(0, $album_data['album_auth_access']));

			if (!$album_data['album_name'])
			{
				trigger_error('MISSING_ALBUM_NAME');
			}
			$album_data['parent_id'] = ($album_data['parent_id']) ? $album_data['parent_id'] : $phpbb_ext_gallery_user->get_data('personal_album_id');
			if ($album_data['parent_id'])
			{
				// Make sure the chosen parent actually belongs to this user before we graft the new album under it.
				$phpbb_ext_gallery_core_album->check_user($album_data['parent_id']);
			}
			generate_text_for_storage($album_data['album_desc'], $album_data['album_desc_uid'], $album_data['album_desc_bitfield'], $album_data['album_desc_options'], $request->variable('desc_parse_bbcode', false), $request->variable('desc_parse_urls', false), $request->variable('desc_parse_smilies', false));

			/**
			* borrowed from phpBB3
			* @author phpBB Group
			* @location: acp_forums->manage_forums
			*/
			// Parent should always be filled otherwise we use initialise_album()
			if ($album_data['parent_id'])
			{
				$sql = 'SELECT left_id, right_id, album_type
					FROM ' . $albums_table . '
					WHERE album_id = ' . (int) $album_data['parent_id'];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error('PARENT_NOT_EXIST', E_USER_WARNING);
				}

				$sql = 'UPDATE ' . $albums_table . '
					SET left_id = left_id + 2, right_id = right_id + 2
					WHERE left_id > ' . (int) $row['right_id'] . '
						AND album_user_id = ' . (int) $album_data['album_user_id'];
				$db->sql_query($sql);

				$sql = 'UPDATE ' . $albums_table . '
					SET right_id = right_id + 2
					WHERE ' . (int) $row['left_id'] . ' BETWEEN left_id AND right_id
						AND album_user_id = ' . (int) $album_data['album_user_id'];
				$db->sql_query($sql);

				$album_data['left_id'] = $row['right_id'];
				$album_data['right_id'] = $row['right_id'] + 1;
			}
			$db->sql_query('INSERT INTO ' . $albums_table . ' ' . $db->sql_build_array('INSERT', $album_data));
			$redirect_album_id = $db->sql_nextid();

			$this->subscribe_pegas($redirect_album_id);

			$cache->destroy('_albums');
			$cache->destroy('sql', $albums_table);
			$cache->destroy('sql', $users_table);
			$phpbb_ext_gallery_core_auth->set_user_permissions('all', '');

			trigger_error($this->language->lang('CREATED_SUBALBUM') . '<br /><br />
				<a href="' . (($redirect) ? $phpbb_gallery_url->append_sid('album', "album_id=$redirect_album_id") : $phpbb_gallery_url->append_sid('phpbb', 'ucp', 'i=-phpbbgallery-core-ucp-main_module&amp;mode=manage_albums&amp;action=manage&amp;parent_id=' . (($album_data['parent_id']) ? $album_data['parent_id'] : $phpbb_ext_gallery_user->get_data('personal_album_id')))) . '">' . $user->lang('BACK_TO_PREV') . '</a>');
		}
	}

	public function edit_album(): void
	{
		global $config, $cache, $db, $template, $user, $phpbb_gallery_url, $phpbb_ext_gallery_core_album, $phpbb_ext_gallery_core_auth, $albums_table, $phpbb_ext_gallery_core_album_display;
		global $request, $phpbb_container, $phpbb_ext_gallery_user, $users_table;

		$this->language = $phpbb_container->get('language');

		$phpbb_gallery_url->_include(['bbcode','message_parser'], 'phpbb');

		$album_id = $request->variable('album_id', 0);
		$phpbb_ext_gallery_core_album->check_user($album_id);

		$submit = $request->is_set_post('submit');
		$redirect = $request->variable('redirect', '');
		if (!$submit)
		{
			$album_data = $phpbb_ext_gallery_core_album->get_info($album_id);
			$album_desc_data = generate_text_for_edit($album_data['album_desc'], $album_data['album_desc_uid'], $album_data['album_desc_options']);

			// Make sure no direct child forums are able to be selected as parents.
			$exclude_albums = [$album_id];
			foreach ($phpbb_ext_gallery_core_album_display->get_branch($album_data['album_user_id'], $album_id, 'children') as $row)
			{
				$exclude_albums[] = (int) $row['album_id'];
			}

			$parents_list = $phpbb_ext_gallery_core_album->get_albumbox(false, '', $album_data['parent_id'], false, $exclude_albums, $user->data['user_id']);

			$s_access_options = '';
			if ($phpbb_ext_gallery_core_auth->acl_check('a_restrict', $phpbb_ext_gallery_core_auth::OWN_ALBUM) && $album_data['parent_id'])
			{
				$access_options = [
					$phpbb_ext_gallery_core_auth::ACCESS_ALL			=> 'ALL',
					$phpbb_ext_gallery_core_auth::ACCESS_REGISTERED	=> 'REGISTERED',
					$phpbb_ext_gallery_core_auth::ACCESS_NOT_FOES		=> 'NOT_FOES',
					$phpbb_ext_gallery_core_auth::ACCESS_FRIENDS		=> 'FRIENDS',
				];
				if (isset($config['zebra_enhance_version']))
				{
					$access_options[$phpbb_ext_gallery_core_auth::ACCESS_SPECIAL_FRIENDS] = 'SPECIAL_FRIENDS';
				}
				foreach ($access_options as $value => $lang_key)
				{
					$s_access_options .= '<option value="' . $value . (($value == $album_data['album_auth_access']) ? '" selected="selected' : '') . '">' . $this->language->lang('ACCESS_CONTROL_' . $lang_key) . '</option>';
				}
			}

			$template->assign_vars([
				'S_EDIT_SUBALBUM'			=> true,
				'S_PERSONAL_ALBUM'			=> ($album_id == $phpbb_ext_gallery_user->get_data('personal_album_id')) ? true : false,
				'S_AUTH_ACCESS_OPTIONS'		=> $s_access_options,
				'L_ALBUM_ACCESS_EXPLAIN'	=> $this->language->lang('ALBUM_ACCESS_EXPLAIN', '<a href="' . $phpbb_gallery_url->append_sid('phpbb', 'faq') . '#f6r0">', '</a>'),

				'L_TITLE'					=> $this->language->lang('EDIT_SUBALBUM'),
				'L_TITLE_EXPLAIN'			=> $this->language->lang('EDIT_SUBALBUM_EXP'),

				'S_UCP_ACTION' 				=> $this->u_action . '&amp;action=edit&amp;album_id=' . $album_id . (($redirect != '') ? '&amp;redirect=album' : ''),
				'S_PARENT_OPTIONS'			=> '<option value="' . $phpbb_ext_gallery_user->get_data('personal_album_id') . '">' . $this->language->lang('NO_PARENT_ALBUM') . '</option>' . $parents_list,

				'ALBUM_NAME' 				=> $album_data['album_name'],
				'ALBUM_DESC'				=> $album_desc_data['text'],
				'ALBUM_TYPE'				=> $album_data['album_type'],
				'S_DESC_BBCODE_CHECKED'		=> ($album_desc_data['allow_bbcode']) ? true : false,
				'S_DESC_SMILIES_CHECKED'	=> ($album_desc_data['allow_smilies']) ? true : false,
				'S_DESC_URLS_CHECKED'		=> ($album_desc_data['allow_urls']) ? true : false,

				'S_MODE' 					=> 'edit',
			]);
		}
		else
		{
			// Is it salty ?
			if (!check_form_key('ucp_gallery'))
			{
				trigger_error('FORM_INVALID');
			}

			$album_data = [
				'album_name'					=> ($album_id == $phpbb_ext_gallery_user->get_data('personal_album_id')) ? $user->data['username'] : $request->variable('album_name', '', true),
				'parent_id'						=> $request->variable('parent_id', (($album_id == $phpbb_ext_gallery_user->get_data('personal_album_id')) ? 0 : $phpbb_ext_gallery_user->get_data('personal_album_id'))),
				//left_id and right_id are created some lines later
				'album_parents'					=> '',
				'album_type'					=> (int) \phpbbgallery\core\block::TYPE_UPLOAD,
				'album_desc_options'			=> 7,
				'album_desc'					=> utf8_normalize_nfc($request->variable('album_desc', '', true)),
				'album_auth_access'				=> ($phpbb_ext_gallery_core_auth->acl_check('a_restrict', $phpbb_ext_gallery_core_auth::OWN_ALBUM)) ? $request->variable('album_auth_access', 0) : 0,
			];

			generate_text_for_storage($album_data['album_desc'], $album_data['album_desc_uid'], $album_data['album_desc_bitfield'], $album_data['album_desc_options'], $request->variable('desc_parse_bbcode', false), $request->variable('desc_parse_urls', false), $request->variable('desc_parse_smilies', false));
			$old_data = $phpbb_ext_gallery_core_album->get_info($album_id);
			if (!$old_data['parent_id'])
			{
				// do not allow to restrict access on the base-album
				$album_data['album_auth_access'] = 0;
			}

			$owner_id = (int) $old_data['album_user_id'];
			$personal_root_id = (int) $phpbb_ext_gallery_user->get_data('personal_album_id');
			$requested_parent_id = (int) $album_data['parent_id'];
			$parent_id = (int) $old_data['parent_id'];
			$phpbb_ext_gallery_core_album->check_user($personal_root_id, $owner_id);

			// Neither a second root nor a cycle may be introduced into a personal tree.
			$invalid_parent_ids = [0, $album_id];
			foreach ($phpbb_ext_gallery_core_album_display->get_branch($owner_id, $album_id, 'children') as $loop)
			{
				$invalid_parent_ids[] = (int) $loop['album_id'];
			}

			$personal_album_ids = [];
			foreach ($phpbb_ext_gallery_core_album_display->get_branch($owner_id, $personal_root_id, 'children') as $loop)
			{
				$personal_album_ids[] = (int) $loop['album_id'];
			}

			if ($requested_parent_id !== $parent_id && !in_array($requested_parent_id, $invalid_parent_ids, true))
			{
				// Reject foreign or missing albums before considering the selected destination.
				$phpbb_ext_gallery_core_album->check_user($requested_parent_id, $owner_id);
				if (in_array($requested_parent_id, $personal_album_ids, true))
				{
					$parent_id = $requested_parent_id;
				}
			}
			$album_data['parent_id'] = $parent_id;

			// If the parent is different, the left_id and right_id have changed.
			if ((int) $old_data['parent_id'] !== $parent_id)
			{
				$album_manage = $phpbb_container->get('phpbbgallery.core.album.manage');
				$album_manage->set_user($owner_id);
				$errors = $album_manage->move_album($album_id, $parent_id);
				if ($errors)
				{
					$album_data['parent_id'] = (int) $old_data['parent_id'];
				}
			}

			// The album name has changed, clear the parents list of all albums.
			if ($album_data['album_name'] == '')
			{
				$album_data['album_name'] = $old_data['album_name'];
			}
			else if ($old_data['album_name'] != $album_data['album_name'])
			{
				$sql = 'UPDATE ' . $albums_table . "
					SET album_parents = ''
					WHERE " . $db->sql_in_set('album_user_id', [$owner_id]);
				$db->sql_query($sql);
			}

			// The album access has changed, clear the permissions of all users.
			if (isset($config['zebra_enhance_version']))
			{
				$album_data['album_auth_access'] = min(4, max(0, $album_data['album_auth_access']));
			}
			else
			{
				$album_data['album_auth_access'] = min(3, max(0, $album_data['album_auth_access']));
			}
			if ($old_data['album_auth_access'] != $album_data['album_auth_access'])
			{
				$phpbb_ext_gallery_core_auth->set_user_permissions('all', '');
			}

			$sql = 'UPDATE ' . $albums_table . ' 
					SET ' . $db->sql_build_array('UPDATE', $album_data) . '
					WHERE album_id  = ' . (int) $album_id . '
						AND ' . $db->sql_in_set('album_user_id', [$owner_id]);
			$db->sql_query($sql);

			$cache->destroy('sql', $albums_table);
			$cache->destroy('sql', $users_table);
			$cache->destroy('_albums');

			trigger_error($this->language->lang('EDITED_SUBALBUM') . '<br /><br />
				<a href="' . (($redirect) ? $phpbb_gallery_url->append_sid('album', "album_id=$album_id") : $phpbb_gallery_url->append_sid('phpbb', 'ucp', 'i=-phpbbgallery-core-ucp-main_module&amp;mode=manage_albums&amp;action=manage&amp;parent_id=' . (($album_data['parent_id']) ? $album_data['parent_id'] : $phpbb_ext_gallery_user->get_data('personal_album_id')))) . '">' . $this->language->lang('BACK_TO_PREV') . '</a>');
		}
	}

	public function delete_album(): void
	{
		global $cache, $db, $template, $user, $phpbb_gallery_url, $phpbb_ext_gallery_core_album, $albums_table, $phpbb_container;
		global $images_table, $phpbb_gallery_image, $phpbb_ext_gallery_config, $phpbb_dispatcher, $request, $users_table;
		global $comments_table, $images_table, $rates_table, $reports_table, $watch_table, $tracking_table, $phpbb_ext_gallery_core_auth, $phpbb_ext_gallery_user;

		$this->language = $phpbb_container->get('language');

		$s_hidden_fields = build_hidden_fields([
			'album_id'		=> $request->variable('album_id', 0),
		]);

		if (confirm_box(true))
		{
			$album_id = $request->variable('album_id', 0, false, \phpbb\request\request_interface::POST);
			$phpbb_ext_gallery_core_album->check_user($album_id);
			$left_id = $right_id = 0;
			$parent_id = 0;
			$deleted_images_na = '';
			$album = $deleted_albums = [];

			// Check for owner
			$sql = 'SELECT album_id, left_id, right_id, parent_id
				FROM ' . $albums_table . '
				WHERE album_user_id = ' . (int) $user->data['user_id'] . '
				ORDER BY left_id ASC';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$album[] = $row;
				if ($row['album_id'] == $album_id)
				{
					$left_id = (int) $row['left_id'];
					$right_id = (int) $row['right_id'];
					$parent_id = (int) $row['parent_id'];
				}
			}
			$db->sql_freeresult($result);

			for ($i = 0, $end = count($album); $i < $end; $i++)
			{
				if (($left_id <= $album[$i]['left_id']) && ($album[$i]['left_id'] <= $right_id))
				{
					$deleted_albums[] = $album[$i]['album_id'];
				}
			}

			// $deleted_albums is the array of albums we are going to delete.
			// Now get the images in $deleted_images
			$sql = 'SELECT image_id, image_filename, image_status
				FROM ' . $images_table . '
				WHERE ' . $db->sql_in_set('image_album_id', $deleted_albums) . '
				ORDER BY image_id ASC';
			$result = $db->sql_query($sql);

			$deleted_images = $filenames = [];
			$contains_protected_images = false;
			while ($row = $db->sql_fetchrow($result))
			{
				$deleted_images[] = $row['image_id'];
				$filenames[(int) $row['image_id']] = $row['image_filename'];
				if ((int) $row['image_status'] !== (int) \phpbbgallery\core\block::STATUS_ORPHAN)
				{
					$contains_protected_images = true;
				}
			}
			$db->sql_freeresult($result);
			if ($contains_protected_images)
			{
				trigger_error($this->language->lang('DELETE_ALBUM_REQUIRES_EMPTY'));
			}

			// We have all image_ids in $deleted_images which are deleted.
			// Aswell as the album_ids in $deleted_albums.
			// So now drop the comments, ratings, images and albums.
			if (!empty($deleted_images))
			{
				$phpbb_gallery_image->delete_images($deleted_images, $filenames);
			}

			$sql = 'DELETE FROM ' . $albums_table . '
				WHERE ' . $db->sql_in_set('album_id', $deleted_albums);
			$db->sql_query($sql);

			$sql = 'DELETE FROM ' . $tracking_table . '
				WHERE ' . $db->sql_in_set('album_id', $deleted_albums);
			$db->sql_query($sql);

			// Make sure the overall image & comment count is correct...
			$sql = 'SELECT COUNT(image_id) AS num_images, SUM(image_comments) AS num_comments
				FROM ' . $images_table . '
				WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
					AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
					AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$phpbb_ext_gallery_config->set('num_images', $row['num_images']);
			$phpbb_ext_gallery_config->set('num_comments', (int) $row['num_comments']);

			// Maybe we deleted all, so we have to empty phpbb_gallery::$user->get_data('personal_album_id')
			if (in_array($phpbb_ext_gallery_user->get_data('personal_album_id'), $deleted_albums))
			{
				$phpbb_ext_gallery_user->update_data([
					'personal_album_id'		=> 0,
				]);

				$phpbb_ext_gallery_config->dec('num_pegas', 1);

				if ($phpbb_ext_gallery_config->get('newest_pega_album_id') == $phpbb_ext_gallery_user->get_data('personal_album_id'))
				{
					// Update the config for the statistic on the index
					$newest_pgallery = false;
					if ($phpbb_ext_gallery_config->get('num_pegas') > 0)
					{
						$sql_array = [
							'SELECT'		=> 'a.album_id, u.user_id, u.username, u.user_colour',
							'FROM'			=> [$albums_table => 'a'],

							'LEFT_JOIN'		=> [
								[
									'FROM'		=> [USERS_TABLE => 'u'],
									'ON'		=> 'u.user_id = a.album_user_id',
								],
							],

							'WHERE'			=> 'a.album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . ' AND a.parent_id = 0',
							'ORDER_BY'		=> 'a.album_id DESC',
						];
						$sql = $db->sql_build_query('SELECT', $sql_array);
						$result = $db->sql_query_limit($sql, 1);
						$newest_pgallery = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);
					}
					$this->update_newest_personal_gallery_config($phpbb_ext_gallery_config, $newest_pgallery);
				}
			}
			else
			{
				// Solve the left_id right_id problem
				$delete_id = $right_id - ($left_id - 1);

				$sql = 'UPDATE ' . $albums_table . "
					SET left_id = left_id - $delete_id
					WHERE left_id > $left_id
						AND album_user_id = " . (int) $user->data['user_id'];
				$db->sql_query($sql);

				$sql = 'UPDATE ' . $albums_table . "
					SET right_id = right_id - $delete_id
					WHERE right_id > $right_id
						AND album_user_id = ". (int) $user->data['user_id'];
				$db->sql_query($sql);
			}

			/**
			* Event delete user albums
			*
			* @event phpbbgallery.core.ucp.delete_album
			* @var	int		album_id			Album ID
			* @var	array	deleted_albums		Deleted album IDs
			* @since 1.2.0
			*/
			$vars = ['album_id', 'deleted_albums'];
			extract($phpbb_dispatcher->trigger_event('phpbbgallery.core.ucp.delete_album', compact($vars)));

			$cache->destroy('sql', $albums_table);
			$cache->destroy('sql', $comments_table);
			$cache->destroy('sql', $images_table);
			$cache->destroy('sql', $rates_table);
			$cache->destroy('sql', $reports_table);
			$cache->destroy('sql', $watch_table);
			$cache->destroy('sql', $users_table);
			$cache->destroy('_albums');
			$phpbb_ext_gallery_core_auth->set_user_permissions('all', '');

			trigger_error($this->language->lang('DELETED_ALBUMS') . '<br /><br />
				<a href="' . (($parent_id) ? $phpbb_gallery_url->append_sid('phpbb', 'ucp', 'i=-phpbbgallery-core-ucp-main_module&amp;mode=manage_albums&amp;action=manage&amp;parent_id=' . $parent_id) : $phpbb_gallery_url->append_sid('phpbb', 'ucp', 'i=-phpbbgallery-core-ucp-main_module&amp;mode=manage_albums')) . '">' . $this->language->lang('BACK_TO_PREV') . '</a>');
		}
		else
		{
			$album_id = $request->variable('album_id', 0);
			$phpbb_ext_gallery_core_album->check_user($album_id);
			confirm_box(false, 'DELETE_ALBUM', $s_hidden_fields, 'confirm_body.html', $this->u_action . '&amp;action=delete');
		}
	}

	/**
	 * Store the newest personal gallery or reset stale statistics.
	 *
	 * @param \phpbbgallery\core\config $gallery_config Gallery configuration
	 * @param array|false $gallery Newest personal gallery row
	 * @return void
	 */
	protected function update_newest_personal_gallery_config(\phpbbgallery\core\config $gallery_config, array|false $gallery): void
	{
		if ($gallery !== false)
		{
			$gallery_config->set('newest_pega_user_id', (int) $gallery['user_id']);
			$gallery_config->set('newest_pega_username', (string) $gallery['username']);
			$gallery_config->set('newest_pega_user_colour', (string) $gallery['user_colour']);
			$gallery_config->set('newest_pega_album_id', (int) $gallery['album_id']);
			return;
		}

		$gallery_config->set('newest_pega_user_id', 0);
		$gallery_config->set('newest_pega_username', '');
		$gallery_config->set('newest_pega_user_colour', '');
		$gallery_config->set('newest_pega_album_id', 0);
		$gallery_config->set('num_pegas', 0);
	}

	public function move_album(): bool
	{
		global $cache, $db, $user, $phpbb_ext_gallery_core_album, $albums_table, $request, $phpbb_gallery_url, $users_table;

		if (!$this->is_valid_form_submission($request, 'move'))
		{
			trigger_error('FORM_INVALID');
		}

		$album_id = $request->variable('album_id', 0, false, \phpbb\request\request_interface::POST);
		$phpbb_ext_gallery_core_album->check_user($album_id);

		$move = $request->variable('move', '', true, \phpbb\request\request_interface::POST);
		if (!$this->is_valid_move_direction($move))
		{
			trigger_error('FORM_INVALID');
		}
		$moving = $phpbb_ext_gallery_core_album->get_info($album_id);
		$moving_parent_id = (int) $moving['parent_id'];
		$moving_left_id = (int) $moving['left_id'];
		$moving_right_id = (int) $moving['right_id'];
		$user_id = (int) $user->data['user_id'];

		$sql = 'SELECT album_id, left_id, right_id
			FROM ' . $albums_table . "
			WHERE parent_id = $moving_parent_id
				AND album_user_id = $user_id
				AND " . (($move === 'move_up') ? "right_id < $moving_right_id ORDER BY right_id DESC" : "left_id > $moving_left_id ORDER BY left_id ASC");
		$result = $db->sql_query_limit($sql, 1);
		$target = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$target)
		{
			// The album is already on top or bottom
			return false;
		}
		$target_left_id = (int) $target['left_id'];
		$target_right_id = (int) $target['right_id'];

		if ($move === 'move_up')
		{
			$left_id = $target_left_id;
			$right_id = $moving_right_id;

			$diff_up = $moving_left_id - $target_left_id;
			$diff_down = $moving_right_id + 1 - $moving_left_id;

			$move_up_left = $moving_left_id;
			$move_up_right = $moving_right_id;
		}
		else
		{
			$left_id = $moving_left_id;
			$right_id = $target_right_id;

			$diff_up = $moving_right_id + 1 - $moving_left_id;
			$diff_down = $target_right_id - $moving_right_id;

			$move_up_left = $moving_right_id + 1;
			$move_up_right = $target_right_id;
		}

		// Now do the dirty job
		$sql = 'UPDATE ' . $albums_table . "
			SET left_id = left_id + CASE
				WHEN left_id BETWEEN {$move_up_left} AND {$move_up_right} THEN -{$diff_up}
				ELSE {$diff_down}
			END,
			right_id = right_id + CASE
				WHEN right_id BETWEEN {$move_up_left} AND {$move_up_right} THEN -{$diff_up}
				ELSE {$diff_down}
			END,
			album_parents = ''
			WHERE
				left_id BETWEEN {$left_id} AND {$right_id}
				AND right_id BETWEEN {$left_id} AND {$right_id}
				AND album_user_id = $user_id";
		$db->sql_query($sql);

		$cache->destroy('sql', $albums_table);
		$cache->destroy('sql', $users_table);
		$cache->destroy('_albums');
		$phpbb_gallery_url->redirect('phpbb', 'ucp', 'i=-phpbbgallery-core-ucp-main_module&amp;mode=manage_albums&amp;action=manage&amp;parent_id=' . $moving_parent_id);

		return true;
	}

	public function manage_subscriptions(): void
	{
		global $db, $template, $user, $phpbb_container, $phpbb_ext_gallery_core_album, $phpbb_gallery_notification, $watch_table, $albums_table;
		global $images_table, $comments_table, $request, $phpbb_gallery_url, $phpbb_ext_gallery_core_auth;

		$phpbb_ext_gallery_core_image = $phpbb_container->get('phpbbgallery.core.image');
		$phpbb_ext_gallery_config = $phpbb_container->get('phpbbgallery.core.config');
		$phpbb_gallery_notification = $phpbb_container->get('phpbbgallery.core.notification');
		$image_visibility = $phpbb_container->get('phpbbgallery.core.policy.image_visibility');
		$album_data_enricher = $phpbb_container->get('phpbbgallery.core.album.data_enricher');
		$this->language = $phpbb_container->get('language');

		$action = $request->variable('action', '', true, \phpbb\request\request_interface::POST);
		$image_id_ary = $request->variable('image_id_ary', [0], false, \phpbb\request\request_interface::POST);
		$album_id_ary = $request->variable('album_id_ary', [0], false, \phpbb\request\request_interface::POST);
		if (($image_id_ary || $album_id_ary) && ($action === 'unsubscribe'))
		{
			if (!$this->is_valid_form_submission($request, 'action'))
			{
				trigger_error('FORM_INVALID');
			}

			if ($album_id_ary)
			{
				$phpbb_gallery_notification->remove_albums($album_id_ary);
			}
			if ($image_id_ary)
			{
				$phpbb_gallery_notification->remove($image_id_ary);
			}

			meta_refresh(3, $this->u_action);
			$message = '';
			if ($album_id_ary)
			{
				$message .= $this->language->lang('UNWATCHED_ALBUMS') . '<br />';
			}
			if ($image_id_ary)
			{
				$message .= $this->language->lang('UNWATCHED_IMAGES') . '<br />';
			}
			$message .= '<br />' . sprintf($this->language->lang('RETURN_UCP'), '<a href="' . $this->u_action . '">', '</a>');
			trigger_error($message);
		}

		// Subscribed albums
		$last_image_projection = 'last_image_visibility_marker';
		$sql_array = [
			'SELECT'		=> 'w.*, a.*, ' . $image_visibility->projection_sql('li', $last_image_projection),
			'FROM'			=> [$watch_table => 'w'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [$albums_table => 'a'],
					'ON'		=> 'w.album_id = a.album_id',
				],
				[
					'FROM'		=> [$images_table => 'li'],
					'ON'		=> 'li.image_id = a.album_last_image_id',
				],
			],

			'WHERE'			=> 'w.album_id <> 0 AND w.user_id = ' . (int) $user->data['user_id'],
		];
		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query($sql);
		$album_rows = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$album_rows[] = $row;
		}
		$db->sql_freeresult($result);
		$album_rows = $album_data_enricher->enrich_many($album_rows);
		foreach ($album_rows as $row)
		{
			$can_moderate = $phpbb_ext_gallery_core_auth->acl_check('m_status', $row['album_id'], $row['album_user_id']);
			$last_image_data = $image_visibility->projected_data($row, $last_image_projection, [
				'image_user_id' => $row['album_last_user_id'],
			]);
			$hide_private_data = $image_visibility->hides_private_data(
				$last_image_data,
				(int) $user->data['user_id'],
				$can_moderate
			);
			$private_data_label = $hide_private_data ? $image_visibility->private_data_label(
				$last_image_data,
				(int) $user->data['user_id'],
				$can_moderate,
				$this->language->lang('GALLERY_PRIVATE_USER')
			) : '';
			$template->assign_block_vars('album_row', [
				'ALBUM_ID'			=> $row['album_id'],
				'ALBUM_NAME'		=> $row['album_name'],
				'U_VIEW_ALBUM'		=> $phpbb_gallery_url->show_album($row['album_id']),
				'ALBUM_DESC'		=> generate_text_for_display($row['album_desc'], $row['album_desc_uid'], $row['album_desc_bitfield'], $row['album_desc_options']),

				'UC_IMAGE_NAME'		=> $phpbb_ext_gallery_core_image->generate_link('image_name', $phpbb_ext_gallery_config->get('link_image_name'), $row['album_last_image_id'], $row['album_last_image_name'], $row['album_id']),
				'UC_FAKE_THUMBNAIL'	=> $phpbb_ext_gallery_core_image->generate_link('fake_thumbnail', $phpbb_ext_gallery_config->get('link_thumbnail'), $row['album_last_image_id'], $row['album_last_image_name'], $row['album_id']),
				'UPLOADER'			=> $hide_private_data ? $private_data_label : get_username_string('full', $row['album_last_user_id'], $row['album_last_username'], $row['album_last_user_colour']),
				'LAST_IMAGE_TIME'	=> $user->format_date($row['album_last_image_time']),
				'LAST_IMAGE'		=> $row['album_last_image_id'],
				'U_IMAGE'			=> $phpbb_gallery_url->show_image($row['album_last_image_id']),
			]);
		}

		// Subscribed images
		$start				= $request->variable('start', 0);
		$images_per_page	= $phpbb_ext_gallery_config->get('items_per_page');
		$total_images		= 0;

		$sql = 'SELECT COUNT(image_id) as images
			FROM ' . $watch_table . '
			WHERE image_id <> 0
				AND user_id = ' . (int) $user->data['user_id'];
		$result = $db->sql_query($sql);
		$total_images = (int) $db->sql_fetchfield('images');
		$db->sql_freeresult($result);

		$sql_array = [
			'SELECT'		=> 'w.*, i.*, a.album_name, a.album_user_id, c.*',
			'FROM'			=> [$watch_table => 'w'],

			'LEFT_JOIN'		=> [
				[
					'FROM'		=> [$images_table => 'i'],
					'ON'		=> 'w.image_id = i.image_id',
				],
				[
					'FROM'		=> [$albums_table => 'a'],
					'ON'		=> 'a.album_id = i.image_album_id',
				],
				[
					'FROM'		=> [$comments_table => 'c'],
					'ON'		=> 'i.image_last_comment = c.comment_id',
				],
			],

			'WHERE'			=> 'w.image_id <> 0 AND w.user_id = ' . (int) $user->data['user_id'],
		];
		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query_limit($sql, $images_per_page, $start);
		while ($row = $db->sql_fetchrow($result))
		{
			$can_moderate = $phpbb_ext_gallery_core_auth->acl_check('m_status', $row['image_album_id'], $row['album_user_id']);
			$hide_private_data = $image_visibility->hides_private_data(
				$row,
				(int) $user->data['user_id'],
				$can_moderate
			);
			$private_data_label = $hide_private_data ? $image_visibility->private_data_label(
				$row,
				(int) $user->data['user_id'],
				$can_moderate,
				$this->language->lang('GALLERY_PRIVATE_USER')
			) : '';
			$hide_results = $image_visibility->hides_results($row, $can_moderate);
			$template->assign_block_vars('image_row', [
				'UPLOADER'			=> $hide_private_data ? $private_data_label : get_username_string('full', $row['image_user_id'], $row['image_username'], $row['image_user_colour']),
				'LAST_COMMENT_BY'	=> $hide_results ? false : get_username_string('full', $row['comment_user_id'], $row['comment_username'], $row['comment_user_colour']),
				'COMMENT'			=> $hide_results ? 0 : $row['image_comments'],
				'LAST_COMMENT'		=> (!$hide_results && $row['image_comments']) ? generate_text_for_display($row['comment'], $row['comment_uid'], $row['comment_bitfield'], 7) : '',
				'LAST_COMMENT_TIME'	=> $hide_results ? false : $user->format_date($row['comment_time']),
				'IMAGE_TIME'		=> $user->format_date($row['image_time']),
				'UC_IMAGE_NAME'		=> $phpbb_ext_gallery_core_image->generate_link('image_name', $phpbb_ext_gallery_config->get('link_image_name'), $row['image_id'], $row['image_name'], $row['album_id']),
				'UC_FAKE_THUMBNAIL'	=> $phpbb_ext_gallery_core_image->generate_link('fake_thumbnail', $phpbb_ext_gallery_config->get('link_thumbnail'), $row['image_id'], $row['image_name'], $row['album_id']),
				'ALBUM_NAME'		=> $row['album_name'],
				'IMAGE_ID'			=> $row['image_id'],
				'U_VIEW_ALBUM'		=> $phpbb_gallery_url->show_album($row['image_album_id']),
				'U_IMAGE'			=> $phpbb_gallery_url->show_image($row['image_id']),
			]);
		}
		$db->sql_freeresult($result);

		$template->assign_vars([
			'S_MANAGE_SUBSCRIPTIONS'	=> true,
			'S_UCP_ACTION'				=> $this->u_action,

			'L_TITLE'					=> $this->language->lang('UCP_GALLERY_WATCH'),
			'L_TITLE_EXPLAIN'			=> $this->language->lang('YOUR_SUBSCRIPTIONS'),

			//'PAGINATION'				=> generate_pagination($phpbb_ext_gallery->url->append_sid('phpbb', 'ucp', 'i=-phpbbgallery-core-ucp-main_module&amp;mode=manage_subscriptions'), $total_images, $images_per_page, $start),
			//'PAGE_NUMBER'				=> on_page($total_images, $images_per_page, $start),
			//'TOTAL_IMAGES'				=> $user->lang('VIEW_ALBUM_IMAGES', $total_images),

			'DISP_FAKE_THUMB'			=> true,
			'FAKE_THUMB_SIZE'			=> $phpbb_ext_gallery_config->get('mini_thumbnail_size'),
		]);
	}

	public function subscribe_pegas(int $album_id): void
	{
		global $db, $users_table, $phpbb_container;
		$phpbb_gallery_notification = $phpbb_container->get('phpbbgallery.core.notification');

		$sql = 'SELECT user_id
			FROM ' . $users_table . '
			WHERE subscribe_pegas = 1';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$phpbb_gallery_notification->add_albums($album_id, (int) $row['user_id']);
		}
		$db->sql_freeresult($result);
	}

	/**
	 * Build the Gallery UCP action independently from the current request path.
	 *
	 * @param \phpbbgallery\core\url $url  Gallery URL service
	 * @param string                 $id   UCP module identifier
	 * @param string                 $mode UCP module mode
	 * @return string
	 */
	private function build_ucp_action(\phpbbgallery\core\url $url, string $id, string $mode): string
	{
		return $url->append_sid('phpbb', 'ucp', 'i=' . rawurlencode($id) . '&mode=' . rawurlencode($mode));
	}

	/**
	 * Validate a state-changing UCP form submission.
	 *
	 * @param object    $request        phpBB request service
	 * @param string    $field          Field that must have been submitted by POST
	 * @param bool|null $form_key_valid Optional test override
	 * @return bool
	 */
	private function is_valid_form_submission(object $request, string $field, ?bool $form_key_valid = null): bool
	{
		if (!$request->is_set_post($field))
		{
			return false;
		}

		if ($form_key_valid !== null)
		{
			return $form_key_valid;
		}

		return check_form_key('ucp_gallery');
	}

	/**
	 * Validate an album movement direction.
	 *
	 * @param string $move Movement direction
	 * @return bool
	 */
	private function is_valid_move_direction(string $move): bool
	{
		return in_array($move, ['move_up', 'move_down'], true);
	}
}
