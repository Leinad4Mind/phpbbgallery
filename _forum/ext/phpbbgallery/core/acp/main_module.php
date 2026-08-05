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
 */

namespace phpbbgallery\core\acp;

/**
* @package acp
*/
class main_module
{
	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';
	public \phpbb\language\language $language;

	public function main(string $id, string $mode): void
	{
		global $user, $language;
		global $request, $phpbb_container, $gallery_url;

		$this->language = $phpbb_container->get('language');

		$gallery_url = $phpbb_container->get('phpbbgallery.core.url');

		$this->language->add_lang(['gallery_acp', 'gallery'], 'phpbbgallery/core');
		$this->tpl_name = 'gallery_main';
		add_form_key('acp_gallery');
		$submode = $request->variable('submode', '');

		switch ($mode)
		{
			case 'overview':
				$title = 'ACP_GALLERY_OVERVIEW';
				$this->page_title = $this->language->lang($title);

				$this->overview();
			break;

			default:
				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}
	}

	public function overview(): void
	{
		global $auth, $config, $db, $template, $user, $table_prefix, $phpbb_root_path;
		global $phpbb_container, $request, $gallery_url;

		$this->language = $phpbb_container->get('language');
		$phpbbgallery_core_file = $phpbb_root_path . 'files/phpbbgallery/core';
		$phpbbgallery_core_file_medium = $phpbb_root_path . 'files/phpbbgallery/core/medium';
		$phpbbgallery_core_file_mini = $phpbb_root_path . 'files/phpbbgallery/core/mini';
		$phpbbgallery_core_file_source = $phpbb_root_path . 'files/phpbbgallery/core/source';

		$albums_table = $table_prefix . 'gallery_albums';
		$roles_table = $table_prefix . 'gallery_roles';
		$permissions_table = $table_prefix . 'gallery_permissions';
		$modscache_table = $table_prefix . 'gallery_modscache';
		$users_table = $table_prefix . 'gallery_users';
		$images_table = $table_prefix . 'gallery_images';
		// Init album
		$phpbb_ext_gallery_core_album = $phpbb_container->get('phpbbgallery.core.album');

		// init users
		$phpbb_gallery_user = $phpbb_container->get('phpbbgallery.core.user');

		// init image
		$phpbb_gallery_image = $phpbb_container->get('phpbbgallery.core.image');

		// init config
		$phpbb_ext_gallery_config = $phpbb_container->get('phpbbgallery.core.config');
		$storage_migrator = $phpbb_container->get('phpbbgallery.core.storage.layout_migrator');
		$distributed_storage = $phpbb_ext_gallery_config->get('storage_layout') === \phpbbgallery\core\storage\key_generator::LAYOUT_DISTRIBUTED;

		// init rating
		$phpbb_gallery_rating = $phpbb_container->get('phpbbgallery.core.rating');
		$phpbb_dispatcher = $phpbb_container->get('dispatcher');

		$action = $request->variable('action', '');
		$id = $request->variable('i', '');
		$mode = 'overview';
		if ($request->is_set_post('storage_migration_continue'))
		{
			if (!check_form_key('acp_gallery'))
			{
				trigger_error('FORM_INVALID');
			}
			if (!$auth->acl_get('a_board') || !$distributed_storage)
			{
				trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$this->run_storage_layout_migration($storage_migrator, $request, $template);
			return;
		}

		// before we start let's check if directory structure is OK
		if (!is_writable($phpbb_root_path . 'files'))
		{
			$template->assign_vars([
				'U_FILE_DIR_STATE'	=> $this->language->lang('NO_WRITE_ACCESS'),
				'U_FILE_DIR_STATE_ERROR'	=> 1,
				'U_CORE_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
				'U_CORE_DIR_STATE_ERROR'	=> 1,
				'U_MEDIUM_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
				'U_MEDIUM_DIR_STATE_ERROR'	=> 1,
				'U_MINI_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
				'U_MINI_DIR_STATE_ERROR'	=> 1,
				'U_SOURCE_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
				'U_SOURCE_DIR_STATE_ERROR'	=> 1,
			]);
		}
		else
		{
			$template->assign_vars([
				'U_FILE_DIR_STATE'	=>  $this->language->lang('WRITE_ACCESS'),
				'U_FILE_DIR_STATE_ERROR'	=> 0,
			]);
			if (!file_exists($phpbbgallery_core_file))
			{
				mkdir($phpbbgallery_core_file, 0755, true);
				$template->assign_vars([
					'U_CORE_DIR_STATE'	=>  $this->language->lang('DIR_CREATED'),
					'U_CORE_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else if (is_writable($phpbbgallery_core_file))
			{
				$template->assign_vars([
					'U_CORE_DIR_STATE'	=>  $this->language->lang('WRITE_ACCESS'),
					'U_CORE_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else
			{
				$template->assign_vars([
					'U_CORE_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
					'U_CORE_DIR_STATE_ERROR'	=> 1,
				]);
			}
			if (!file_exists($phpbbgallery_core_file_medium))
			{
				mkdir($phpbbgallery_core_file_medium, 0755, true);
				$template->assign_vars([
					'U_MEDIUM_DIR_STATE'	=>  $this->language->lang('DIR_CREATED'),
					'U_MEDIUM_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else if (is_writable($phpbbgallery_core_file_medium))
			{
				$template->assign_vars([
					'U_MEDIUM_DIR_STATE'	=>  $this->language->lang('WRITE_ACCESS'),
					'U_MEDIUM_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else
			{
				$template->assign_vars([
					'U_MEDIUM_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
					'U_MEDIUM_DIR_STATE_ERROR'	=> 1,
				]);
			}
			if (!file_exists($phpbbgallery_core_file_mini))
			{
				mkdir($phpbbgallery_core_file_mini, 0755, true);
				$template->assign_vars([
					'U_MINI_DIR_STATE'	=>  $this->language->lang('DIR_CREATED'),
					'U_MINI_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else if (is_writable($phpbbgallery_core_file_mini))
			{
				$template->assign_vars([
					'U_MINI_DIR_STATE'	=>  $this->language->lang('WRITE_ACCESS'),
					'U_MINI_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else
			{
				$template->assign_vars([
					'U_MINI_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
					'U_MINI_DIR_STATE_ERROR'	=> 1,
				]);
			}
			if (!file_exists($phpbbgallery_core_file_source))
			{
				mkdir($phpbbgallery_core_file_source, 0755, true);
				$template->assign_vars([
					'U_SOURCE_DIR_STATE'	=>  $this->language->lang('DIR_CREATED'),
					'U_SOURCE_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else if (is_writable($phpbbgallery_core_file_source))
			{
				$template->assign_vars([
					'U_SOURCE_DIR_STATE'	=>  $this->language->lang('WRITE_ACCESS'),
					'U_SOURCE_DIR_STATE_ERROR'	=> 0,
				]);
			}
			else
			{
				$template->assign_vars([
					'U_SOURCE_DIR_STATE'	=>  $this->language->lang('NO_WRITE_ACCESS'),
					'U_SOURCE_DIR_STATE_ERROR'	=> 1,
				]);
			}
		}
		$this->assign_environment_status($template, $phpbb_container->get('ext.manager'));
		if (!confirm_box(true))
		{
			$confirm = false;
			$album_id = 0;
			switch ($action)
			{
				case 'images':
					$confirm = true;
					$confirm_lang = 'RESYNC_IMAGECOUNTS_CONFIRM';
				break;
				case 'personals':
					$confirm = true;
					$confirm_lang = 'CONFIRM_OPERATION';
				break;
				case 'stats':
					$confirm = true;
					$confirm_lang = 'CONFIRM_OPERATION';
				break;
				case 'last_images':
					$confirm = true;
					$confirm_lang = 'CONFIRM_OPERATION';
				break;
				case 'reset_rating':
					$album_id = $request->variable('reset_album_id', 0);
					$album_data = $phpbb_ext_gallery_core_album->get_info($album_id);
					$confirm = true;
					$confirm_lang = sprintf($this->language->lang('RESET_RATING_CONFIRM'), $album_data['album_name']);
				break;
				case 'purge_cache':
					$confirm = true;
					$confirm_lang = 'GALLERY_PURGE_CACHE_EXPLAIN';
				break;
				case 'resync_albums_to_cpf':
					$confirm = true;
					$confirm_lang = 'GALLERY_RESYNC_ALBUMS_TO_CPF_CONFIRM';
				break;
				case 'storage_migrate':
					if (!$auth->acl_get('a_board') || !$distributed_storage)
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
					}
					$confirm = true;
					$confirm_lang = 'STORAGE_MIGRATION_CONFIRM';
				break;
				case 'create_pega':
					$confirm = false;
					if (!check_form_key('acp_gallery'))
					{
						trigger_error('FORM_INVALID');
					}
					if (!$auth->acl_get('a_board'))
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$username = $request->variable('username', '', true);
					$user_id = 0;
					if ($username)
					{
						if (!function_exists('user_get_id_name'))
						{
							$gallery_url->_include('functions_user', 'phpbb');
						}
						user_get_id_name($user_id, $username);
					}
					if (is_array($user_id))
					{
						$user_id = (isset($user_id[0])) ? $user_id[0] : 0;
					}

					$sql = 'SELECT username, user_colour, user_id
						FROM ' . USERS_TABLE . '
						WHERE user_id = ' . (int) $user_id;
					$result = $db->sql_query($sql);
					$user_row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);
					if (!$user_row)
					{
						trigger_error($this->language->lang('NO_USER') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$image_user = $phpbb_gallery_user->set_user_id($user_row['user_id']);
					$album_id = $phpbb_gallery_user->get_data('personal_album_id');

					if ($album_id)
					{
						trigger_error($this->language->lang('PEGA_ALREADY_EXISTS', $user_row['username']) . adm_back_link($this->u_action), E_USER_WARNING);
					}
					$album_id = $phpbb_ext_gallery_core_album->generate_personal_album($user_row['username'], $user_row['user_id'], $user_row['user_colour'], $phpbb_gallery_user);

					trigger_error($this->language->lang('PEGA_CREATED', $user_row['username']) . adm_back_link($this->u_action));
				break;
			}

			if ($confirm)
			{
				confirm_box(false, (($album_id) ? $confirm_lang : $this->language->lang($confirm_lang)), build_hidden_fields([
					'i'			=> $id,
					'mode'		=> $mode,
					'action'	=> $action,
					'reset_album_id'	=> $album_id,
				]), 'confirm_body.html', $this->u_action);
			}
		}
		else
		{
			switch ($action)
			{
				case 'images':
					if (!$auth->acl_get('a_board'))
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$total_images = $total_comments = 0;
					$phpbb_gallery_user->update_users('all', ['user_images' => 0]);

					$sql = 'SELECT COUNT(image_id) AS num_images, image_user_id AS user_id, SUM(image_comments) AS num_comments
						FROM ' . $images_table . '
						WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
							AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
							AND image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED . '
						GROUP BY image_user_id';
					$result = $db->sql_query($sql);

					while ($row = $db->sql_fetchrow($result))
					{
						$total_images += $row['num_images'];
						$total_comments += (int) $row['num_comments'];

						$image_user = $phpbb_container->get('phpbbgallery.core.user');
						$image_user->set_user_id($row['user_id'], false);
						$image_user->update_data([
							'user_images'		=> $row['num_images'],
						]);
					}
					$db->sql_freeresult($result);

					$sql = 'SELECT SUM(image_view_count) AS num_views
						FROM ' . $images_table;
					$result = $db->sql_query($sql);
					$total_views = (int) $db->sql_fetchfield('num_views');
					$db->sql_freeresult($result);

					$phpbb_ext_gallery_config->set('num_images', $total_images);
					$phpbb_ext_gallery_config->set('num_comments', $total_comments);
					$phpbb_ext_gallery_config->set('num_views', $total_views, false);
					trigger_error($this->language->lang('RESYNCED_IMAGECOUNTS') . adm_back_link($this->u_action));
				break;

				case 'personals':
					if (!$auth->acl_get('a_board'))
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$phpbb_gallery_user->update_users('all', ['personal_album_id' => 0]);

					$sql = 'SELECT album_id, album_user_id
						FROM ' . $albums_table . '
						WHERE album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . '
							AND parent_id = 0
						GROUP BY album_user_id, album_id';
					$result = $db->sql_query($sql);

					$number_of_personals = 0;
					while ($row = $db->sql_fetchrow($result))
					{
						$image_user = $phpbb_gallery_user->set_user_id($row['album_user_id'], false);
						$phpbb_gallery_user->update_data([
							'personal_album_id'		=> $row['album_id'],
						]);
						$number_of_personals++;
					}
					$db->sql_freeresult($result);
					$phpbb_ext_gallery_config->set('num_pegas', $number_of_personals);

					// Update the config for the statistic on the index
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
					$newest_pgallery = $db->sql_fetchrow($result) ?: [];
					$db->sql_freeresult($result);

					$this->update_newest_personal_gallery_config($phpbb_ext_gallery_config, $newest_pgallery);

					trigger_error($this->language->lang('RESYNCED_PERSONALS') . adm_back_link($this->u_action));
				break;

				case 'stats':
					if (!$auth->acl_get('a_board'))
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					// Hopefully this won't take to long! >> I think we must make it batchwise
					$sql = 'SELECT image_id, image_filename
						FROM ' . $images_table . '
						WHERE filesize_upload = 0';
					$result = $db->sql_query($sql);
					$image_filesizes = [];
					while ($row = $db->sql_fetchrow($result))
					{
						$image_filesizes[(int) $row['image_id']] = [
							'filesize_upload' => (int) @filesize($gallery_url->path('upload') . $row['image_filename']),
							'filesize_medium' => (int) @filesize($gallery_url->path('medium') . $row['image_filename']),
							'filesize_cache'  => (int) @filesize($gallery_url->path('thumbnail') . $row['image_filename']),
						];
					}
					$db->sql_freeresult($result);
					$this->update_image_filesizes($db, $images_table, $image_filesizes);

					redirect($this->u_action);
				break;

				case 'last_images':
					$sql = 'SELECT album_id
						FROM ' . $albums_table;
					$result = $db->sql_query($sql);

					$album_ids = [];
					while ($row = $db->sql_fetchrow($result))
					{
						$album_ids[] = (int) $row['album_id'];
					}
					$db->sql_freeresult($result);
					$phpbb_ext_gallery_core_album->update_last_images($album_ids);
					trigger_error($this->language->lang('RESYNCED_LAST_IMAGES') . adm_back_link($this->u_action));
				break;

				case 'reset_rating':
					$album_id = $request->variable('reset_album_id', 0);

					$image_ids = [];
					$sql = 'SELECT image_id
						FROM ' . $images_table . '
						WHERE image_album_id = ' . (int) $album_id;
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$image_ids[] = $row['image_id'];
					}
					$db->sql_freeresult($result);

					$this->reset_album_ratings($phpbb_gallery_rating, $image_ids);

					/**
					 * Notify optional providers after every rating in an album is reset.
					 *
					 * @event phpbbgallery.core.acp.album_ratings_reset
					 * @var int   album_id Album whose ratings were reset
					 * @var array image_ids Images included in the reset
					 * @since 4.1.0
					 */
					$vars = ['album_id', 'image_ids'];
					extract($phpbb_dispatcher->trigger_event(
						'phpbbgallery.core.acp.album_ratings_reset',
						compact($vars)
					));

					trigger_error($this->language->lang('RESET_RATING_COMPLETED') . adm_back_link($this->u_action));
				break;

				case 'purge_cache':
					if ($user->data['user_type'] != USER_FOUNDER)
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$cache_dir = @opendir($gallery_url->path('thumbnail'));
					while ($cache_dir !== false && ($cache_file = readdir($cache_dir)) !== false)
					{
						if (preg_match('/(\.webp$|\.gif$|\.png$|\.jpg|\.jpeg)$/is', $cache_file))
						{
							@unlink($gallery_url->path('thumbnail') . $cache_file);
						}
					}
					if ($cache_dir !== false)
					{
						closedir($cache_dir);
					}

					$medium_dir = @opendir($gallery_url->path('medium'));
					while ($medium_dir !== false && ($medium_file = readdir($medium_dir)) !== false)
					{
						if (preg_match('/(\.webp$|\.gif$|\.png$|\.jpg|\.jpeg)$/is', $medium_file))
						{
							@unlink($gallery_url->path('medium') . $medium_file);
						}
					}
					if ($medium_dir !== false)
					{
						closedir($medium_dir);
					}
					$upload_dir = @opendir($gallery_url->path('upload'));
					while ($upload_dir !== false && ($upload_file = readdir($upload_dir)) !== false)
					{
						if (preg_match('/(\_wm.webp$|\_wm.gif$|\_wm.png$|\_wm.jpg|\_wm.jpeg)$/is', $upload_file))
						{
							@unlink($gallery_url->path('upload') . $upload_file);
						}
					}
					if ($upload_dir !== false)
					{
						closedir($upload_dir);
					}

					for ($i = 1; $i <= $phpbb_ext_gallery_config->get('current_upload_dir'); $i++)
					{
						$cache_dir = @opendir($gallery_url->path('thumbnail') . $i . '/');
						while ($cache_dir !== false && ($cache_file = readdir($cache_dir)) !== false)
						{
							if (preg_match('/(\.webp$|\.gif$|\.png$|\.jpg|\.jpeg)$/is', $cache_file))
							{
								@unlink($gallery_url->path('thumbnail') . $i . '/' . $cache_file);
							}
						}
						if ($cache_dir !== false)
						{
							closedir($cache_dir);
						}

						$medium_dir = @opendir($gallery_url->path('medium') . $i . '/');
						while ($medium_dir !== false && ($medium_file = readdir($medium_dir)) !== false)
						{
							if (preg_match('/(\.webp$|\.gif$|\.png$|\.jpg|\.jpeg)$/is', $medium_file))
							{
								@unlink($gallery_url->path('medium') . $i . '/' . $medium_file);
							}
						}
						if ($medium_dir !== false)
						{
							closedir($medium_dir);
						}
						$upload_dir = @opendir($gallery_url->path('upload') . $i . '/');
						while ($upload_dir !== false && ($upload_file = readdir($upload_dir)) !== false)
						{
							if (preg_match('/(\_wm.webp$|\_wm.gif$|\_wm.png$|\_wm.jpg|\_wm.jpeg)$/is', $upload_file))
							{
								@unlink($gallery_url->path('upload') . $i . '/' . $upload_file);
							}
						}
						if ($upload_dir !== false)
						{
							closedir($upload_dir);
						}
					}

					$sql_ary = [
						'filesize_medium'		=> 0,
						'filesize_cache'		=> 0,
					];
					$sql = 'UPDATE ' . $images_table . '
						SET ' . $db->sql_build_array('UPDATE', $sql_ary);
					$db->sql_query($sql);

					trigger_error($this->language->lang('PURGED_CACHE') . adm_back_link($this->u_action));
				break;

				case 'resync_albums_to_cpf':
					$resync_albums_to_cpf_stage = 'gather';
				break;

				case 'storage_migrate':
					if (!$auth->acl_get('a_board') || !$distributed_storage)
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$this->run_storage_layout_migration($storage_migrator, $request, $template);
					return;
			}
		}

		/* Resync stats as per server
		 * Time: 0.271s
		 * Queries: 1087
		 * Peak Memory usage: 8.62MB
		 */
		if (isset($resync_albums_to_cpf_stage))
		{
			// We will loop a resync
			// Let's gather some info
			$sync_users = [];
			$sql = 'SELECT user_id FROM ' . $users_table . ' ORDER BY user_id ASC';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				$sync_users[] = (int) $row['user_id'];
			}
			$phpbb_gallery_user->set_personal_albums($sync_users);
			$db->sql_freeresult($result);
		}

		$boarddays = (time() - $config['board_startdate']) / 86400;
		$images_per_day = sprintf('%.2f', ($boarddays > 0) ? ($config['phpbb_gallery_num_images'] / $boarddays) : 0);

		$sql = 'SELECT COUNT(album_user_id) AS num_albums
			FROM ' . $albums_table . '
			WHERE album_user_id = 0';
		$result = $db->sql_query($sql);
		$num_albums = (int) $db->sql_fetchfield('num_albums');
		$db->sql_freeresult($result);

		$sql = 'SELECT SUM(filesize_upload) AS stat, SUM(filesize_medium) AS stat_medium, SUM(filesize_cache) AS stat_cache
			FROM ' . $images_table;
		$result = $db->sql_query($sql);
		$dir_sizes = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$storage_status = $distributed_storage ? $storage_migrator->status() : [];
		$template->assign_vars([
			'S_GALLERY_OVERVIEW'			=> true,
			'ACP_GALLERY_TITLE'				=> $this->language->lang('ACP_GALLERY_OVERVIEW'),
			'ACP_GALLERY_TITLE_EXPLAIN'		=> $this->language->lang('ACP_GALLERY_OVERVIEW_EXPLAIN'),

			'TOTAL_IMAGES'			=> $config['phpbb_gallery_num_images'],
			'TOTAL_VIEWS'			=> $phpbb_ext_gallery_config->get('num_views'),
			'IMAGES_PER_DAY'		=> $images_per_day,
			'TOTAL_ALBUMS'			=> $num_albums,
			'TOTAL_PERSONALS'		=> $config['phpbb_gallery_num_pegas'],
			'GUPLOAD_DIR_SIZE'	=> get_formatted_filesize($dir_sizes['stat']),
			'MEDIUM_DIR_SIZE'		=> get_formatted_filesize($dir_sizes['stat_medium']),
			'CACHE_DIR_SIZE'		=> get_formatted_filesize($dir_sizes['stat_cache']),
			'GALLERY_VERSION'		=> $config['phpbb_gallery_version'],
			'U_FIND_USERNAME'		=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=action_create_pega_form&amp;field=username&amp;select_single=true'),
			'S_SELECT_ALBUM'		=> $phpbb_ext_gallery_core_album->get_albumbox(false, 'reset_album_id', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),

			'S_FOUNDER'				=> ($user->data['user_type'] == USER_FOUNDER) ? true : false,
			'S_STORAGE_DISTRIBUTED'	=> $distributed_storage,
			'S_STORAGE_MIGRATION_AVAILABLE' => $distributed_storage && $auth->acl_get('a_board') && (($storage_status['pending'] ?? 0) > 0),
			'S_STORAGE_MIGRATION_ISSUES' => ($storage_status['invalid'] ?? 0) > 0,
			'S_STORAGE_MIGRATION_PENDING' => (int) ($storage_status['pending'] ?? 0),
			'S_STORAGE_MIGRATION_DISTRIBUTED' => (int) ($storage_status['distributed'] ?? 0),
			'S_STORAGE_MIGRATION_INVALID' => (int) ($storage_status['invalid'] ?? 0),
			'U_ACTION'				=> $this->u_action,
		]);
	}

	private function run_storage_layout_migration(
		\phpbbgallery\core\storage\layout_migrator $migrator,
		\phpbb\request\request_interface $request,
		\phpbb\template\template $template
	): void
	{
		$summary = $migrator->migrate_batch($request->variable('storage_after_id', 0), 25);
		$migrated = $request->variable('storage_migrated', 0) + $summary['migrated'];
		$skipped = $request->variable('storage_skipped', 0) + $summary['skipped'];
		$failed = $request->variable('storage_failed', 0) + $summary['failed'];

		$template->assign_vars([
			'ACP_GALLERY_TITLE' => $this->language->lang('STORAGE_MIGRATION'),
			'ACP_GALLERY_TITLE_EXPLAIN' => $this->language->lang('STORAGE_MIGRATION_EXPLAIN'),
			'S_STORAGE_MIGRATION_PROGRESS' => true,
			'S_STORAGE_MIGRATION_MORE' => $summary['has_more'],
			'S_STORAGE_MIGRATION_FAILED' => $failed > 0,
			'S_STORAGE_MIGRATED' => $migrated,
			'S_STORAGE_SKIPPED' => $skipped,
			'S_STORAGE_FAILED' => $failed,
			'S_STORAGE_AFTER_ID' => $summary['last_id'],
			'U_ACTION' => $this->u_action,
		]);
	}

	/**
	 * Update the newest personal-gallery statistics, including an empty gallery.
	 *
	 * @param object $gallery_config Gallery configuration service
	 * @param array  $gallery        Newest personal-gallery row
	 */
	private function update_newest_personal_gallery_config(object $gallery_config, array $gallery): void
	{
		$gallery_config->set('newest_pega_user_id', (int) ($gallery['user_id'] ?? 0));
		$gallery_config->set('newest_pega_username', (string) ($gallery['username'] ?? ''));
		$gallery_config->set('newest_pega_user_colour', (string) ($gallery['user_colour'] ?? ''));
		$gallery_config->set('newest_pega_album_id', (int) ($gallery['album_id'] ?? 0));
	}

	/**
	 * Update cached image file sizes in bounded batches.
	 *
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param string                                $images_table
	 * @param array                                 $image_filesizes File sizes indexed by image ID
	 */
	private function update_image_filesizes(
		\phpbb\db\driver\driver_interface $db,
		string $images_table,
		array $image_filesizes
	): void
	{
		foreach (array_chunk($image_filesizes, 250, true) as $batch)
		{
			$assignments = [];
			foreach (['filesize_upload', 'filesize_medium', 'filesize_cache'] as $column)
			{
				$cases = [];
				foreach ($batch as $image_id => $filesizes)
				{
					$cases[] = 'WHEN ' . (int) $image_id . ' THEN ' . (int) ($filesizes[$column] ?? 0);
				}

				$assignments[] = $column . ' = CASE image_id ' . implode(' ', $cases) . ' ELSE ' . $column . ' END';
			}

			$sql = 'UPDATE ' . $images_table . '
				SET ' . implode(', ', $assignments) . '
				WHERE ' . $db->sql_in_set('image_id', array_keys($batch));
			$db->sql_query($sql);
		}
	}

	/**
	 * Reset every image rating in an album.
	 *
	 * @param object $rating    Gallery rating service
	 * @param array  $image_ids Image identifiers
	 */
	private function reset_album_ratings(object $rating, array $image_ids): void
	{
		if (!empty($image_ids))
		{
			$rating->delete_ratings($image_ids, true);
		}
	}

	/**
	 * Assign PHP runtime and Gallery add-on diagnostics to the overview.
	 *
	 * @param \phpbb\template\template $template
	 * @param object                     $extension_manager phpBB extension manager
	 */
	private function assign_environment_status(\phpbb\template\template $template, object $extension_manager): void
	{
		$environment = new environment();
		foreach ($environment->runtime_checks() as $check)
		{
			$template->assign_block_vars('runtime_checks', [
				'NAME' => $check['name'],
				'VERSION' => $check['version'] !== '' ? $check['version'] : $this->language->lang('GALLERY_STATUS_NOT_AVAILABLE'),
				'S_AVAILABLE' => $check['available'],
				'S_ERROR' => $check['required'] && !$check['available'],
				'REQUIREMENT' => $this->language->lang($check['requirement'], environment::MINIMUM_PHP_VERSION),
			]);
		}

		$status_keys = [
			'enabled' => 'GALLERY_ADDON_ENABLED',
			'disabled' => 'GALLERY_ADDON_DISABLED',
			'not_installed' => 'GALLERY_ADDON_NOT_INSTALLED',
			'not_available' => 'GALLERY_ADDON_NOT_AVAILABLE',
		];
		$addon_groups = [];
		foreach ($environment->addon_checks($extension_manager) as $addon)
		{
			$addon_groups[$addon['tier']][] = $addon;
		}
		foreach (['free' => 'GALLERY_ADDON_FREE', 'premium' => 'GALLERY_ADDON_PREMIUM'] as $tier => $title_key)
		{
			if (empty($addon_groups[$tier]))
			{
				continue;
			}

			$template->assign_block_vars('addon_groups', [
				'TITLE' => $this->language->lang($title_key),
			]);
			foreach ($addon_groups[$tier] as $addon)
			{
				$template->assign_block_vars('addon_groups.addons', [
					'NAME' => $addon['name'],
					'EXTENSION' => $addon['extension'],
					'VERSION' => $addon['version'],
					'DESCRIPTION' => $this->language->lang($addon['description']),
					'S_ENABLED' => $addon['status'] === 'enabled',
					'S_MISSING' => $addon['status'] === 'not_available',
					'STATUS' => $this->language->lang($status_keys[$addon['status']]),
				]);
			}
		}
	}
}
