<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 *
 * mostly borrowed from phpBB3
 * @author phpBB Group
 * @location: includes/acp/acp_forums.php
 *
 * Note: There are several code parts commented out, for example the album/forum_password.
 *       I didn't remove them, to have it easier when I implement this feature one day. I hope it's okay.
 */

namespace phpbbgallery\core\acp;

/**
* @package acp
*/
class albums_module
{
	public string $u_action = '';
	public int $parent_id = 0;
	public \phpbb\language\language $language;
	public string $tpl_name = '';
	public string $page_title = '';

	public function main(string $id, string $mode): void
	{
		global $auth, $cache, $config, $db, $template, $user, $phpbb_root_path, $phpbb_ext_gallery, $request;
		global $phpbb_dispatcher, $table_prefix, $table_name, $phpbb_container, $moderators_table, $permissions_table, $roles_table, $users_table;
		$helper = $phpbb_container->get('controller.helper');
		$pagination = $phpbb_container->get('pagination');
		$this->language = $phpbb_container->get('language');

		// Let us define some helpers;
		$albums_table = $table_prefix . 'gallery_albums';
		// Init ext gallery
		$this->language->add_lang(['gallery_acp', 'gallery'], 'phpbbgallery/core');

		$gallery_user = $phpbb_container->get('phpbbgallery.core.user');
		$phpbb_ext_gallery_core_auth = $phpbb_container->get('phpbbgallery.core.auth');
		$phpbb_ext_gallery_core_url = $phpbb_container->get('phpbbgallery.core.url');
		$icon_manager = $phpbb_container->get('phpbbgallery.core.icon.manager');

		// Init manage albums
		$manage_albums = $phpbb_container->get('phpbbgallery.core.album.manage');
		$manage_albums->set_user($request->variable('user_id', 0));
		$manage_albums->set_parent($request->variable('parent_id', 0));
		$manage_albums->set_u_action($this->u_action);

		// Init album
		$phpbb_ext_gallery_core_album = $phpbb_container->get('phpbbgallery.core.album');

		$phpbb_ext_gallery_core_album_display = $phpbb_container->get('phpbbgallery.core.album.display');

		$album_type_registry = $phpbb_container->get('phpbbgallery.core.album.type_registry');

		$this->tpl_name = 'gallery_albums';
		$this->page_title = 'ACP_GALLERY_MANAGE_ALBUMS';

		$form_key = 'acp_gallery_albums';
		add_form_key($form_key);

		$action		= $request->variable('action', '');
		// An icon upload/pick must survive the round trip the same way a failed save
		// does, so $album_data built below is kept rather than reloaded from the DB.
		$update		= $request->is_set_post('update') || $request->is_set_post('upload_icon');
		$album_id	= $request->variable('a', 0);

		$this->parent_id	= $request->variable('parent_id', 0);
		$album_data = $errors = [];
		if ($update && !check_form_key($form_key))
		{
			$update = false;
			$errors[] = $this->language->lang('FORM_INVALID');
		}

		// Major routines
		if ($update)
		{
			switch ($action)
			{
				case 'delete':
					$action_subalbums	= $request->variable('action_subalbums', '');
					$subalbums_to_id	= $request->variable('subalbums_to_id', 0);
					$action_images		= $request->variable('action_images', '');
					$images_to_id		= $request->variable('images_to_id', 0);

					$errors = $manage_albums->delete_album($album_id, $action_images, $action_subalbums, $images_to_id, $subalbums_to_id);

					if (sizeof($errors))
					{
						break;
					}

					$cache->destroy('sql', $table_prefix . 'gallery_albums');

					trigger_error($this->language->lang('ALBUM_DELETED') . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id));

				break;

				/** @noinspection PhpMissingBreakStatementInspection */
				case 'edit':
					$album_data = [
						'album_id'		=>	$album_id
					];

				// No break; here

				case 'add':

					$album_data += [
						'parent_id'				=> $request->variable('album_parent_id', $this->parent_id),
						'album_type'			=> $request->variable('album_type', (int) \phpbbgallery\core\block::TYPE_UPLOAD),
						'type_action'			=> $request->variable('type_action', ''),
						'album_status'			=> $request->variable('album_status', (int) \phpbbgallery\core\block::ALBUM_OPEN),
						'album_parents'			=> '',
						'album_name'			=> utf8_normalize_nfc($request->variable('album_name', '', true)),
						'album_desc'			=> utf8_normalize_nfc($request->variable('album_desc', '', true)),
						'album_desc_uid'		=> '',
						'album_desc_options'	=> 7,
						'album_desc_bitfield'	=> '',
						'album_image'			=> $request->variable('album_image', ''),
						'album_watermark'		=> $request->variable('album_watermark', false),
						'album_sort_key'		=> $request->variable('album_sort_key', ''),
						'album_sort_dir'		=> $request->variable('album_sort_dir', ''),
						'display_subalbum_list'	=> $request->variable('display_subalbum_list', false),
						'display_on_index'		=> $request->variable('display_on_index', false),
						'display_in_rrc'		=> $request->variable('display_in_rrc', false),
						/*
						'album_password'		=> $request->variable('album_password', '', true),
						'album_password_confirm'=> $request->variable('album_password_confirm', '', true),
						'album_password_unset'	=> $request->variable('album_password_unset', false),
						*/
					];

					// Icon upload/pick is handled separately from a normal save: it must
					// never try to persist the album, and it must never lose whatever the
					// admin was mid-typing in the rest of this form.
					if ($request->is_set_post('upload_icon'))
					{
						$upload_result = $icon_manager->upload('icon_file');

						if ($upload_result['error'])
						{
							$errors[] = $upload_result['error'];
						}
						else
						{
							$album_data['album_image'] = $icon_manager->relative_path($upload_result['filename']);
							$template->assign_var('L_ICON_UPLOADED', $this->language->lang('ICON_UPLOADED'));
						}

					break;
					}

					$album_icon_pick = $request->variable('album_icon_pick', '');
					if ($album_icon_pick !== '')
					{
						if ($icon_manager->is_valid_icon($album_icon_pick))
						{
							$album_data['album_image'] = $icon_manager->relative_path($album_icon_pick);
						}
						else
						{
							$errors[] = $this->language->lang('ICON_INVALID_SELECTION');
						}
					}

					/**
					* Event to send requested data
					* @event phpbbgallery.core.acp.albums.request_data
					* @var	string	action		Action we are taking
					* @var	int		album_id	Album we are doing it to
					* @var	array	album_data	Album data for the album
					* @since 1.2.0
					*/
					$album_type_data = [];
					$vars = ['action', 'album_id', 'album_data', 'album_type_data'];
					extract($phpbb_dispatcher->trigger_event('phpbbgallery.core.acp.albums.request_data', compact($vars)));

					// Categories are not able to be locked...
					if ($album_data['album_type'] == (int) \phpbbgallery\core\block::TYPE_CAT)
					{
						$album_data['album_status'] = (int) \phpbbgallery\core\block::ALBUM_OPEN;
					}

					// Get data for album description if specified
					if ($album_data['album_desc'])
					{
						generate_text_for_storage($album_data['album_desc'], $album_data['album_desc_uid'], $album_data['album_desc_bitfield'], $album_data['album_desc_options'], $request->variable('desc_parse_bbcode', false), $request->variable('desc_parse_urls', false), $request->variable('desc_parse_smilies', false));
					}

					$errors = $manage_albums->update_album_data($album_data, $album_type_data);

					if (!sizeof($errors))
					{
						$album_perm_from = $request->variable('album_perm_from', 0);

						// Copy permissions? You do not need permissions for that in the gallery
						if ($album_perm_from && $album_perm_from != $album_data['album_id'])
						{
							// If we edit a album delete current permissions first
							if ($action == 'edit')
							{
								$sql = 'DELETE FROM ' . $table_prefix . 'gallery_permissions
									WHERE perm_album_id = ' . (int) $album_data['album_id'];
								$db->sql_query($sql);

								$sql = 'DELETE FROM ' . $table_prefix . 'gallery_modscache
									WHERE album_id = ' . (int) $album_data['album_id'];
								$db->sql_query($sql);
							}

							$sql = 'SELECT *
								FROM ' . $table_prefix . 'gallery_permissions
								WHERE perm_album_id = ' . (int) $album_perm_from;
							$result = $db->sql_query($sql);
							$perm_data = [];
							while ($row = $db->sql_fetchrow($result))
							{
								$perm_data[] = [
									'perm_role_id'					=> $row['perm_role_id'],
									'perm_album_id'					=> $album_data['album_id'],
									'perm_user_id'					=> $row['perm_user_id'],
									'perm_group_id'					=> $row['perm_group_id'],
									'perm_system'					=> $row['perm_system'],
								];
							}
							$db->sql_freeresult($result);

							$modscache_ary = [];
							$sql = 'SELECT * FROM ' . $table_prefix . 'gallery_modscache
								WHERE album_id = ' . (int) $album_perm_from;
							$result = $db->sql_query($sql);
							while ($row = $db->sql_fetchrow($result))
							{
								$modscache_ary[] = [
									'album_id'			=> $album_data['album_id'],
									'user_id'			=> $row['user_id'],
									'username'			=> $row['username'],
									'group_id'			=> $row['group_id'],
									'group_name'		=> $row['group_name'],
									'display_on_index'	=> $row['display_on_index'],
								];
							}
							$db->sql_freeresult($result);

							$db->sql_multi_insert($table_prefix . 'gallery_permissions', $perm_data);
							$db->sql_multi_insert($table_prefix . 'gallery_modscache', $modscache_ary);
						}

						$cache->destroy('sql', $table_prefix . 'gallery_albums');
						$cache->destroy('sql', $table_prefix . 'gallery_modscache');
						$cache->destroy('sql', $table_prefix . 'gallery_permissions');
						$cache->destroy('_albums');
						$phpbb_ext_gallery_core_auth->set_user_permissions('all', '');

						$acl_url = '&amp;mode=manage&amp;action=v_mask&amp;album_id[]=' . $album_data['album_id'];

						$message = ($action == 'add') ? $this->language->lang('ALBUM_CREATED') : $this->language->lang('ALBUM_UPDATED');
						$message .= '<br /><br />' . sprintf($this->language->lang('REDIRECT_ACL'), '<a href="' . $phpbb_ext_gallery_core_url->append_sid('admin' , 'index', 'i=-phpbbgallery-core-acp-permissions_module' . $acl_url) . '">', '</a>');

						// Redirect directly to permission settings screen
						if ($action == 'add' && !$album_perm_from)
						{
							meta_refresh(5, $phpbb_ext_gallery_core_url->append_sid('admin' , 'index', 'i=-phpbbgallery-core-acp-permissions_module' . $acl_url));
						}

						trigger_error($message . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id));
					}

				break;
			}
		}

		switch ($action)
		{
			case 'move_up':
			case 'move_down':

				if (!$album_id)
				{
					trigger_error($this->language->lang('NO_ALBUM') . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id), E_USER_WARNING);
				}

				if (!confirm_box(true))
				{
					confirm_box(false, $this->language->lang('CONFIRM_OPERATION'), build_hidden_fields([
						'a'			=> $album_id,
						'action'	=> $action,
						'parent_id'	=> $this->parent_id,
					]), 'confirm_body.html', $this->u_action);
				}

				$sql = 'SELECT *
					FROM ' . $table_prefix . 'gallery_albums
					WHERE album_id = ' . (int) $album_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error($this->language->lang('NO_ALBUM') . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id), E_USER_WARNING);
				}

				$move_album_name = $manage_albums->move_album_by($row, $action, 1);

				if ($move_album_name !== false)
				{
					$log = $phpbb_container->get('phpbbgallery.core.log');
					$log->add_log('admin', 'move', $row['album_id'], 0, ['LOG_ALBUM_' . strtoupper($action), $row['album_name'], $move_album_name]);
					$cache->destroy('sql', $table_prefix . 'gallery_albums');
				}

			break;

			case 'sync':
			case 'sync_album':
				if (!$album_id)
				{
					trigger_error($this->language->lang('NO_ALBUM') . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id), E_USER_WARNING);
				}

				if (!confirm_box(true))
				{
					confirm_box(false, $this->language->lang('CONFIRM_OPERATION'), build_hidden_fields([
						'a'			=> $album_id,
						'action'	=> $action,
						'parent_id'	=> $this->parent_id,
					]), 'confirm_body.html', $this->u_action);
				}

				$sql = 'SELECT album_name, album_type
					FROM ' . $table_prefix . 'gallery_albums
					WHERE album_id = ' . (int) $album_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error($this->language->lang('NO_ALBUM') . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id), E_USER_WARNING);
				}

				$phpbb_ext_gallery_core_album->update_info($album_id);

				$log = $phpbb_container->get('phpbbgallery.core.log');
				$log->add_log('admin', 'resync', $album_id, 0, ['LOG_ALBUM_SYNC', $row['album_name']]);

				$template->assign_var('L_ALBUM_RESYNCED', sprintf($this->language->lang('ALBUM_RESYNCED'), $row['album_name']));

			break;

			case 'add':
			case 'edit':

				// Show form to create/modify a album
				$old_album_type = null;
				if ($action == 'edit')
				{
					$this->page_title = 'EDIT_ALBUM';
					$row = $phpbb_ext_gallery_core_album->get_info($album_id);
					$old_album_type = $row['album_type'];

					if (!$update)
					{
						$album_data = $row;
					}
					else
					{
						$album_data['left_id'] = $row['left_id'];
						$album_data['right_id'] = $row['right_id'];
					}
					$album_type_data = [];
					$vars = ['action', 'album_data', 'album_type_data'];
					extract($phpbb_dispatcher->trigger_event(
						'phpbbgallery.core.acp.albums.load_type_data',
						compact($vars)
					));

					// Make sure no direct child albums are able to be selected as parents.
					$exclude_albums = [];
					foreach ($phpbb_ext_gallery_core_album_display->get_branch((int) \phpbbgallery\core\block::PUBLIC_ALBUM, $album_id, 'children') as $row)
					{
						$exclude_albums[] = $row['album_id'];
					}

					$parents_list = $phpbb_ext_gallery_core_album->get_albumbox(true, '', $album_data['parent_id'], false, $exclude_albums);

				}
				else
				{
					$this->page_title = 'CREATE_ALBUM';

					$album_id = $this->parent_id;
					$parents_list = $phpbb_ext_gallery_core_album->get_albumbox(true, '', $this->parent_id);

					// Fill album data with default values
					if (!$update)
					{
						$album_data = [
							'parent_id'				=> $this->parent_id,
							'album_type'			=> (int) \phpbbgallery\core\block::TYPE_UPLOAD,
							'album_status'			=> (int) \phpbbgallery\core\block::ALBUM_OPEN,
							'album_name'			=> utf8_normalize_nfc($request->variable('album_name', '', true)),
							'album_desc'			=> '',
							'album_image'			=> '',
							'album_watermark'		=> true,
							'album_sort_key'		=> '',
							'album_sort_dir'		=> '',
							'display_subalbum_list'	=> true,
							'display_on_index'		=> true,
							'display_in_rrc'		=> true,
							/*
							'album_password'		=> '',
							'album_password_confirm'=> '',
							*/
						];

						/**
						* Event to send default data
						*
						* @event phpbbgallery.core.acp.albums.default_data
						* @var	action	action		Action taken
						* @var	array	album_data	Album data array
						* @since 1.2.0
						*/
						$album_type_data = [];
						$vars = ['action', 'album_data', 'album_type_data'];
						extract($phpbb_dispatcher->trigger_event('phpbbgallery.core.acp.albums.default_data', compact($vars)));
					}
				}

				$album_desc_data = [
					'text'			=> $album_data['album_desc'],
					'allow_bbcode'	=> true,
					'allow_smilies'	=> true,
					'allow_urls'	=> true
				];

				// Parse description if specified
				if ($album_data['album_desc'])
				{
					if (!isset($album_data['album_desc_uid']))
					{
						// Before we are able to display the preview and plane text, we need to parse our request_var()'d value...
						$album_data['album_desc_uid'] = '';
						$album_data['album_desc_bitfield'] = '';
						$album_data['album_desc_options'] = 0;

						generate_text_for_storage($album_data['album_desc'], $album_data['album_desc_uid'], $album_data['album_desc_bitfield'], $album_data['album_desc_options'], $request->variable('desc_allow_bbcode', false), $request->variable('desc_allow_urls', false), $request->variable('desc_allow_smilies', false));
					}

					// decode...
					$album_desc_data = generate_text_for_edit($album_data['album_desc'], $album_data['album_desc_uid'], $album_data['album_desc_options']);
				}

				$album_type_options = '';
				$album_type_ary = [];
				$current_album_type = (int) $album_data['album_type'];
				foreach ($album_type_registry->get_types(['current_type' => $current_album_type]) as $value => $definition)
				{
					if (!$definition['can_create'] && (int) $value !== $current_album_type)
					{
						continue;
					}

					$album_type_ary[(int) $value] = $definition['lang'];
				}

				foreach ($album_type_ary as $value => $lang)
				{
					$album_type_options .= '<option value="' . $value . '"' . (($value == $album_data['album_type']) ? ' selected="selected"' : '') . '>' . $user->lang['ALBUM_TYPE_' . $lang] . '</option>';
				}

				$album_sort_key_options = '';
				$album_sort_key_options .= '<option' . ((!in_array($album_data['album_sort_key'], ['t', 'n', 'vc', 'u', 'ra', 'r', 'c', 'lc'])) ? ' selected="selected"' : '') . " value=''>" . $this->language->lang('SORT_DEFAULT') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 't') ? ' selected="selected"' : '') . " value='t'>" . $this->language->lang('TIME') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 'n') ? ' selected="selected"' : '') . " value='n'>" . $this->language->lang('IMAGE_NAME') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 'vc') ? ' selected="selected"' : '') . " value='vc'>" . $this->language->lang('GALLERY_VIEWS') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 'u') ? ' selected="selected"' : '') . " value='u'>" . $this->language->lang('USERNAME') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 'ra') ? ' selected="selected"' : '') . " value='ra'>" . $this->language->lang('RATING') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 'r') ? ' selected="selected"' : '') . " value='r'>" . $this->language->lang('RATES_COUNT') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 'c') ? ' selected="selected"' : '') . " value='c'>" . $this->language->lang('COMMENTS') . '</option>';
				$album_sort_key_options .= '<option' . (($album_data['album_sort_key'] == 'lc') ? ' selected="selected"' : '') . " value='lc'>" . $this->language->lang('NEW_COMMENT') . '</option>';

				$album_sort_dir_options = '';
				$album_sort_dir_options .= '<option' . ((($album_data['album_sort_dir'] != 'd') && ($album_data['album_sort_dir'] != 'a')) ? ' selected="selected"' : '') . " value=''>" . $this->language->lang('SORT_DEFAULT') . '</option>';
				$album_sort_dir_options .= '<option' . (($album_data['album_sort_dir'] == 'd') ? ' selected="selected"' : '') . " value='d'>" . $this->language->lang('SORT_DESCENDING') . '</option>';
				$album_sort_dir_options .= '<option' . (($album_data['album_sort_dir'] == 'a') ? ' selected="selected"' : '') . " value='a'>" . $this->language->lang('SORT_ASCENDING') . '</option>';

				$statuslist = '<option value="' . (int) \phpbbgallery\core\block::ALBUM_OPEN . '"' . (($album_data['album_status'] == (int) \phpbbgallery\core\block::ALBUM_OPEN) ? ' selected="selected"' : '') . '>' . $user->lang['UNLOCKED'] . '</option><option value="' . (int) \phpbbgallery\core\block::ALBUM_LOCKED . '"' . (($album_data['album_status'] == (int) \phpbbgallery\core\block::ALBUM_LOCKED) ? ' selected="selected"' : '') . '>' . $user->lang['LOCKED'] . '</option>';

				$sql = 'SELECT album_id
					FROM ' . $table_prefix . 'gallery_albums
					WHERE album_type = ' . (int) \phpbbgallery\core\block::TYPE_UPLOAD . '
						AND album_user_id = ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . '
						AND album_id <> ' . (int) $album_id;
				$result = $db->sql_query_limit($sql, 1);

				$uploadable_album_exists = false;
				if ($db->sql_fetchrow($result))
				{
					$uploadable_album_exists = true;
				}
				$db->sql_freeresult($result);

				// Subalbum move options
				if ($action == 'edit' && $album_type_registry->accepts_images((int) $album_data['album_type']))
				{
					$subalbums_id = [];
					$subalbums = $phpbb_ext_gallery_core_album_display->get_branch((int) \phpbbgallery\core\block::PUBLIC_ALBUM, $album_id, 'children');

					foreach ($subalbums as $row)
					{
						$subalbums_id[] = $row['album_id'];
					}

					$albums_list = $phpbb_ext_gallery_core_album->get_albumbox(true, '', $album_data['parent_id'], false, $subalbums_id);

					if ($uploadable_album_exists)
					{
						$template->assign_vars([
							'S_MOVE_ALBUM_OPTIONS'		=> $phpbb_ext_gallery_core_album->get_albumbox(true, '', $album_data['parent_id'], false, $subalbums_id, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
						]);
					}

					$template->assign_vars([
						'S_HAS_SUBALBUMS'		=> ($album_data['right_id'] - $album_data['left_id'] > 1) ? true : false,
						'S_ALBUMS_LIST'			=> $albums_list,
					]);
				}
				else if ($uploadable_album_exists)
				{
					$template->assign_vars([
						'S_MOVE_ALBUM_OPTIONS'		=> $phpbb_ext_gallery_core_album->get_albumbox(true, '', $album_data['parent_id'], false, $album_id, 0, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
					]);
				}

				$gallery_icons = $icon_manager->list_icons();
				foreach ($gallery_icons as $icon_filename)
				{
					$template->assign_block_vars('iconrow', [
						'ICON_FILE'		=> $icon_filename,
						'ICON_SRC'		=> $phpbb_ext_gallery_core_url->path('phpbb') . $icon_manager->relative_path($icon_filename),
						'S_SELECTED'	=> ($album_data['album_image'] === $icon_manager->relative_path($icon_filename)),
					]);
				}

				$template->assign_vars([
					'S_EDIT_ALBUM'		=> true,
					'S_NO_ICONS_AVAILABLE'	=> empty($gallery_icons),
					'S_ERROR'			=> (sizeof($errors)) ? true : false,
					'S_PARENT_ID'		=> $this->parent_id,
					'S_ALBUM_PARENT_ID'	=> $album_data['parent_id'],
					'S_ADD_ACTION'		=> ($action == 'add') ? true : false,

					'U_BACK'			=> $this->u_action . '&amp;parent_id=' . $this->parent_id,
					'U_EDIT_ACTION'		=> $this->u_action . "&amp;parent_id={$this->parent_id}&amp;action=$action&amp;a=$album_id",

					'L_COPY_PERMISSIONS_EXPLAIN'	=> $user->lang['COPY_PERMISSIONS_' . strtoupper($action) . '_EXPLAIN'],
					'L_TITLE'						=> $user->lang[$this->page_title],
					'ERROR_MSG'						=> (sizeof($errors)) ? implode('<br />', $errors) : '',

					'ALBUM_NAME'				=> $album_data['album_name'],
					'ALBUM_IMAGE'				=> $album_data['album_image'],
					'ALBUM_IMAGE_SRC'			=> ($album_data['album_image']) ? $phpbb_ext_gallery_core_url->path('phpbb') . $album_data['album_image'] : '',
					/*
					'S_ALBUM_PASSWORD_SET'		=> (empty($album_data['album_password'])) ? false : true,
					*/

					'ALBUM_DESC'				=> $album_desc_data['text'],
					'S_DESC_BBCODE_CHECKED'		=> ($album_desc_data['allow_bbcode']) ? true : false,
					'S_DESC_SMILIES_CHECKED'	=> ($album_desc_data['allow_smilies']) ? true : false,
					'S_DESC_URLS_CHECKED'		=> ($album_desc_data['allow_urls']) ? true : false,

					'S_ALBUM_TYPE_OPTIONS'		=> $album_type_options,
					'S_STATUS_OPTIONS'			=> $statuslist,
					'S_PARENT_OPTIONS'			=> $parents_list,
					'S_ALBUM_OPTIONS'			=> $phpbb_ext_gallery_core_album->get_albumbox(true, '', ($action == 'add') ? $album_data['parent_id'] : false, false, ($action == 'edit') ? $album_data['album_id'] : false),

					'S_ALBUM_ORIG_UPLOAD'		=> (isset($old_album_type) && $old_album_type == (int) \phpbbgallery\core\block::TYPE_UPLOAD) ? true : false,
					'S_ALBUM_ORIG_CAT'			=> (isset($old_album_type) && $old_album_type == (int) \phpbbgallery\core\block::TYPE_CAT) ? true : false,
					'S_ALBUM_UPLOAD'			=> ($album_data['album_type'] == (int) \phpbbgallery\core\block::TYPE_UPLOAD) ? true : false,
					'S_ALBUM_CAT'				=> ($album_data['album_type'] == (int) \phpbbgallery\core\block::TYPE_CAT) ? true : false,
					'ALBUM_UPLOAD'				=> (int) \phpbbgallery\core\block::TYPE_UPLOAD,
					'ALBUM_CAT'					=> (int) \phpbbgallery\core\block::TYPE_CAT,
					'S_CAN_COPY_PERMISSIONS'	=> true,

					'S_ALBUM_WATERMARK'			=> ($album_data['album_watermark']) ? true : false,
					'ALBUM_SORT_KEY_OPTIONS'	=> $album_sort_key_options,
					'ALBUM_SORT_DIR_OPTIONS'	=> $album_sort_dir_options,
					'S_DISPLAY_SUBALBUM_LIST'	=> ($album_data['display_subalbum_list']) ? true : false,
					'S_DISPLAY_ON_INDEX'		=> ($album_data['display_on_index']) ? true : false,
					'S_DISPLAY_IN_RRC'			=> ($album_data['display_in_rrc']) ? true : false,
				]);

				/**
				* Event after assigning data to template
				*
				* @event phpbbgallery.core.acp.albums.send_to_template
				* @var	action	action		Action taken
				* @var	array	album_data	Album data array
				* @since 1.2.0
				*/
				$vars = ['action', 'album_data', 'album_type_data', 'old_album_type'];
				extract($phpbb_dispatcher->trigger_event('phpbbgallery.core.acp.albums.send_to_template', compact($vars)));

				return;

			break;

			case 'delete':

				if (!$album_id)
				{
					trigger_error($user->lang['NO_ALBUM'] . adm_back_link($this->u_action . '&amp;parent_id=' . $this->parent_id), E_USER_WARNING);
				}

				$album_data = $phpbb_ext_gallery_core_album->get_info($album_id);

				$subalbums_id = [];
				$subalbums = $phpbb_ext_gallery_core_album_display->get_branch((int) \phpbbgallery\core\block::PUBLIC_ALBUM, $album_id, 'children');

				foreach ($subalbums as $row)
				{
					$subalbums_id[] = $row['album_id'];
				}

				$albums_list = $phpbb_ext_gallery_core_album->get_albumbox(true, '', $album_data['parent_id'], false, $subalbums_id);

				$sql = 'SELECT album_id
					FROM ' . $table_prefix . 'gallery_albums
					WHERE album_type = ' . (int) \phpbbgallery\core\block::TYPE_UPLOAD . '
						AND album_id <> ' . (int) $album_id . '
						AND album_user_id = ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM;
				$result = $db->sql_query_limit($sql, 1);

				if ($db->sql_fetchrow($result))
				{
					$template->assign_vars([
						'S_MOVE_ALBUM_OPTIONS'		=> $phpbb_ext_gallery_core_album->get_albumbox(true, '', $album_data['parent_id'], false, $subalbums_id, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
					]);
				}
				$db->sql_freeresult($result);

				$parent_id = ($this->parent_id == $album_id) ? 0 : $this->parent_id;
				$template->assign_vars([
					'S_DELETE_ALBUM'		=> true,
					'U_ACTION'				=> $this->u_action . "&amp;parent_id={$parent_id}&amp;action=delete&amp;a=" . $album_id,
					'U_BACK'				=> $this->u_action . '&amp;parent_id=' . $this->parent_id,

					'ALBUM_NAME'			=> $album_data['album_name'],
					'S_ALBUM_POST'			=> $album_type_registry->accepts_images((int) $album_data['album_type']),
					'S_HAS_SUBALBUMS'		=> ($album_data['right_id'] - $album_data['left_id'] > 1) ? true : false,
					'S_ALBUMS_LIST'			=> $albums_list,

					'S_ERROR'				=> (sizeof($errors)) ? true : false,
					'ERROR_MSG'				=> (sizeof($errors)) ? implode('<br />', $errors) : '',
				]);

				return;
			break;
		}

		// Default management page
		if (!$this->parent_id)
		{
			$navigation = $user->lang['GALLERY_INDEX'];
		}
		else
		{
			$navigation = '<a href="' . $this->u_action . '">' . $user->lang['GALLERY_INDEX'] . '</a>';

			$albums_nav = $phpbb_ext_gallery_core_album_display->get_branch((int) \phpbbgallery\core\block::PUBLIC_ALBUM, $this->parent_id, 'parents', 'descending');
			foreach ($albums_nav as $row)
			{
				if ($row['album_id'] == $this->parent_id)
				{
					$navigation .= ' -&gt; ' . $row['album_name'];
				}
				else
				{
					$navigation .= ' -&gt; <a href="' . $this->u_action . '&amp;parent_id=' . $row['album_id'] . '">' . $row['album_name'] . '</a>';
				}
			}
		}

		// Jumpbox
		$album_box = $phpbb_ext_gallery_core_album->get_albumbox(true, '', $this->parent_id, false, false);

		if ($action == 'sync' || $action == 'sync_album')
		{
			$template->assign_var('S_RESYNCED', true);
		}

		$sql = 'SELECT *
			FROM ' . $table_prefix . "gallery_albums
			WHERE parent_id = {$this->parent_id}
				AND album_user_id = " . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . '
			ORDER BY left_id';
		$result = $db->sql_query($sql);

		if ($row = $db->sql_fetchrow($result))
		{
			do
			{
				$album_type = $row['album_type'];

				if ($row['album_status'] == (int) \phpbbgallery\core\block::ALBUM_LOCKED)
				{
					$folder_image = '<img src="images/icon_folder_lock.gif" alt="' . $user->lang['LOCKED'] . '" />';
				}
				else
				{
					$folder_image = ($row['left_id'] + 1 != $row['right_id']) ? '<img src="images/icon_subfolder.gif" alt="' . $user->lang['SUBALBUM'] . '" />' : '<img src="images/icon_folder.gif" alt="' . $user->lang['FOLDER'] . '" />';
				}

				$url = $this->u_action . "&amp;parent_id=$this->parent_id&amp;a={$row['album_id']}";

				$template->assign_block_vars('albums', [
					'FOLDER_IMAGE'		=> $folder_image,
					'ALBUM_IMAGE'		=> ($row['album_image']) ? '<img src="' . $phpbb_ext_gallery_core_url->path('phpbb') . $row['album_image'] . '" alt="" />' : '',
					'ALBUM_IMAGE_SRC'	=> ($row['album_image']) ? $phpbb_ext_gallery_core_url->path('phpbb') . $row['album_image'] : '',
					'ALBUM_NAME'		=> $row['album_name'],
					'ALBUM_DESCRIPTION'	=> generate_text_for_display($row['album_desc'], $row['album_desc_uid'], $row['album_desc_bitfield'], $row['album_desc_options']),
					'ALBUM_IMAGES'		=> $row['album_images'],

					'S_ALBUM_POST'		=> ($album_type != (int) \phpbbgallery\core\block::TYPE_CAT) ? true : false,

					'U_ALBUM'			=> $this->u_action . '&amp;parent_id=' . $row['album_id'],
					'U_MOVE_UP'			=> $url . '&amp;action=move_up',
					'U_MOVE_DOWN'		=> $url . '&amp;action=move_down',
					'U_EDIT'			=> $url . '&amp;action=edit',
					'U_DELETE'			=> $url . '&amp;action=delete',
					'U_SYNC'			=> $url . '&amp;action=sync']
				);
			}
			while ($row = $db->sql_fetchrow($result));
		}
		else if ($this->parent_id)
		{
			$row = $phpbb_ext_gallery_core_album->get_info($this->parent_id);

			$url = $this->u_action . '&amp;parent_id=' . $this->parent_id . '&amp;a=' . $row['album_id'];

			$template->assign_vars([
				'S_NO_ALBUMS'		=> true,

				'U_EDIT'			=> $url . '&amp;action=edit',
				'U_DELETE'			=> $url . '&amp;action=delete',
				'U_SYNC'			=> $url . '&amp;action=sync',
			]);
		}
		$db->sql_freeresult($result);

		$template->assign_vars([
			'ERROR_MSG'		=> (sizeof($errors)) ? implode('<br />', $errors) : '',
			'NAVIGATION'	=> $navigation,
			'ALBUM_BOX'		=> $album_box,
			'U_SEL_ACTION'	=> $this->u_action,
			'U_ACTION'		=> $this->u_action . '&amp;parent_id=' . $this->parent_id,

			'U_PROGRESS_BAR'	=> $this->u_action . '&amp;action=progress_bar',
		]);
	}

	/**
	 * Display progress bar for syncing albums
	 *
	 * borrowed from phpBB3
	 * @author phpBB Group
	 * @param int $start
	 * @param int $total
	 */
	public function display_progress_bar(int $start, int $total): void
	{
		global $template, $user;

		adm_page_header($user->lang['SYNC_IN_PROGRESS']);

		$template->set_filenames([
			'body'	=> 'progress_bar.html',
		]);

		$template->assign_vars([
			'L_PROGRESS'			=> $user->lang['SYNC_IN_PROGRESS'],
			'L_PROGRESS_EXPLAIN'	=> ($start && $total) ? sprintf($user->lang['SYNC_IN_PROGRESS_EXPLAIN'], $start, $total) : $user->lang['SYNC_IN_PROGRESS']]
		);

		adm_page_footer();
	}
}
