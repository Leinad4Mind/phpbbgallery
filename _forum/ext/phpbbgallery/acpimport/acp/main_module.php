<?php
/**
 * phpBB Gallery - ACP Import Extension
 *
 * @package   phpbbgallery/acpimport
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\acp;

class main_module
{
	public string $u_action = '';
	public string $tpl_name = '';
	public string $page_title = '';
	private import_storage $import_storage;
	private array $import_errors = [];

	public function main(string $id, string $mode): void
	{
		global $auth, $cache, $config, $db, $template, $user, $phpbb_root_path, $phpbb_container, $gallery_url, $gallery_config, $gallery_album;

		$gallery_url = $phpbb_container->get('phpbbgallery.core.url');
		$gallery_config = $phpbb_container->get('phpbbgallery.core.config');
		$gallery_album = $phpbb_container->get('phpbbgallery.core.album');
		$gallery_url->_include('functions_display', 'phpbb');
		$this->import_storage = new import_storage($gallery_url->path('import'));
		$this->import_storage->remove_legacy_php_state();

		$user->add_lang_ext('phpbbgallery/core', ['gallery_acp', 'gallery']);
		$this->tpl_name = 'gallery_acpimport';
		add_form_key('acp_gallery');

		$this->page_title = $user->lang['ACP_IMPORT_ALBUMS'];
		$this->import();
	}

	public function import(): void
	{
		global $db, $template, $user, $phpbb_dispatcher, $phpbb_container, $gallery_url, $request, $table_prefix, $gallery_config, $gallery_album;

		$import_schema = $request->variable('import_schema', '');
		if ($import_schema && !preg_match('/^[a-f0-9]{32}$/', $import_schema))
		{
			$import_schema = '';
		}
		$images = $request->variable('images', [''], true);

		$submit = $request->is_set_post('submit');

		if ($import_schema)
		{
			$state = $this->import_storage->read_state($import_schema);
			if ($state === false || $state['creator_id'] !== (int) $user->data['user_id'])
			{
				trigger_error($user->lang('MISSING_IMPORT_SCHEMA', $import_schema), E_USER_WARNING);
				return;
			}

			$album_id = $state['album_id'];
			$start_time = $state['start_time'];
			$num_offset = $state['num_offset'];
			$done_images = $state['done_images'];
			$todo_images = $state['todo_images'];
			$image_name = $state['image_name'];
			$filename = $state['filename'];
			$user_data = $state['user_data'];
			$images = $state['images'];
			$this->import_errors = $state['errors'];

			$allowed_extensions = $this->get_allowed_extensions();
			$available_images = $this->import_storage->get_images($allowed_extensions);
			$images_loop = 0;
			$successful_images = 0;
			foreach ($images as $image_key => $image_src)
			{
				/**
				* Import the images
				*/
				$error_occurred = false;
				$safe_image_src = htmlspecialchars($image_src, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
				$image = isset($available_images[$image_src]) ? $available_images[$image_src] : false;
				if ($image === false)
				{
					$this->log_import_error($user->lang('IMPORT_INVALID_IMAGE', $safe_image_src));
					$error_occurred = true;
				}
				else
				{
					$inspection = $this->import_storage->inspect_image($image);
					if ($inspection['error'] === 'mime_mismatch')
					{
						$this->log_import_error(sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $safe_image_src, $inspection['mime']));
						$error_occurred = true;
					}
					else if ($inspection['error'] !== '')
					{
						$this->log_import_error($user->lang['NOT_ALLOWED_FILE_TYPE']);
						$error_occurred = true;
					}
					else
					{
						$filetype = $inspection['image_info'];
						$image_src_full = $image['path'];
						$image_filename = bin2hex(random_bytes(16)) . $inspection['target_extension'];
						$file_link = $gallery_url->path('upload') . $image_filename;
						if (!$this->import_storage->copy_image($image_src_full, $file_link))
						{
							$user->add_lang('posting');
							$this->log_import_error(sprintf($user->lang['GENERAL_UPLOAD_ERROR'], $file_link));
							$error_occurred = true;
						}
					}
				}

				if (!$error_occurred)
				{
					@chmod($file_link, 0644);

					$sql_ary = [
						'image_filename' 		=> $image_filename,
						'image_desc'			=> '',
						'image_desc_uid'		=> '',
						'image_desc_bitfield'	=> '',
						'image_user_id'			=> $user_data['user_id'],
						'image_username'		=> $user_data['username'],
						'image_username_clean'	=> utf8_clean_string($user_data['username']),
						'image_user_colour'		=> $user_data['user_colour'],
						'image_user_ip'			=> $user->ip,
						'image_time'			=> $start_time + $done_images,
						'image_album_id'		=> $album_id,
						'image_status'			=> (int) \phpbbgallery\core\block::STATUS_APPROVED,
						//'image_exif_data'		=> '',
					];

					$image_tools = $phpbb_container->get('phpbbgallery.core.file.tool');
					$image_tools->set_image_options($gallery_config->get('max_filesize'), $gallery_config->get('max_height'), $gallery_config->get('max_width'));
					// force_empty_image=true resets the shared file.tool's state (image/resized/rotated/watermarked)
					// between loop iterations - without it, images after the first oversized one in a batch
					// get the previous image's stale GD buffer written to their destination file.
					$image_tools->set_image_data($file_link, '', 0, true);

					$additional_sql_data = [];

					/**
					* Event to trigger before mass update
					*
					* @event phpbbgallery.acpimport.update_image_before
					* @var	array	additional_sql_data		array of additional sql_data
					* @var	string	file_link				String with real file link
					* @since 1.2.0
					*/
					$vars = ['additional_sql_data', 'file_link'];
					extract($phpbb_dispatcher->trigger_event('phpbbgallery.acpimport.update_image_before', compact($vars)));

					if (($filetype[0] > $gallery_config->get('max_width')) || ($filetype[1] > $gallery_config->get('max_height')))
					{
						/**
						* Resize oversize images
						*/
						if ($gallery_config->get('allow_resize'))
						{
							$image_tools->resize_image($gallery_config->get('max_width'), $gallery_config->get('max_height'));
							if ($image_tools->resized)
							{
								$image_tools->write_image($file_link, $gallery_config->get('jpg_quality'), true);
							}
						}
					}
					$file_updated = (bool) $image_tools->resized;

					/**
					* Event to trigger before mass update
					*
					* @event phpbbgallery.acpimport.update_image
					* @var	array	additional_sql_data		array of additional sql_data
					* @var	bool	file_updated			is file resized
					* @since 1.2.0
					*/
					$vars = ['additional_sql_data', 'file_updated'];
					extract($phpbb_dispatcher->trigger_event('phpbbgallery.acpimport.update_image', compact($vars)));

					$sql_ary = array_merge($sql_ary, $additional_sql_data);

					// Try to get real filesize from temporary folder (not always working) ;)
					$sql_ary['filesize_upload'] = (@filesize($file_link)) ? @filesize($file_link) : 0;

					if ($filename || ($image_name == ''))
					{
						$sql_ary['image_name'] = str_replace('_', ' ', utf8_substr($image_src, 0, utf8_strrpos($image_src, '.')));
					}
					else
					{
						$sql_ary['image_name'] = str_replace('{NUM}', $num_offset + $done_images, $image_name);
					}
					$sql_ary['image_name_clean'] = utf8_clean_string($sql_ary['image_name']);

					// Put the images into the database
					$db->sql_query('INSERT INTO ' . $table_prefix . 'gallery_images ' . $db->sql_build_array('INSERT', $sql_ary));
					// If the source image is imported, we delete it.
					if (file_exists($image_src_full))
					{
						@unlink($image_src_full);
					}
					$successful_images++;
					$done_images++;
				}

				// Remove the image from the list
				unset($images[$image_key]);
				$images_loop++;
				if ($images_loop == 10)
				{
					// We made 10 images, so we end for this turn
					break;
				}
			}
			$images = array_values($images);
			$todo_images = count($images);
			if ($successful_images)
			{
				$image_user = $phpbb_container->get('phpbbgallery.core.user');
				$image_user->set_user_id($user_data['user_id']);
				$image_user->update_images($successful_images);

				$gallery_config->inc('num_images', $successful_images);
			}
			$gallery_album->update_info($album_id);

			if (!$todo_images)
			{
				$this->import_storage->remove_state($import_schema);
				$errors = $this->import_errors;
				if (!$errors)
				{
					trigger_error(sprintf($user->lang['IMPORT_FINISHED'], $done_images) . adm_back_link($this->u_action));
				}
				else
				{
					trigger_error(sprintf($user->lang['IMPORT_FINISHED_ERRORS'], $done_images) . implode('<br />', $errors) . adm_back_link($this->u_action), E_USER_WARNING);
				}
			}
			else
			{
				// Write the new list
				if (!$this->create_import_schema($import_schema, $album_id, $user_data, $start_time, $num_offset, $done_images, $todo_images, $image_name, $filename, $images))
				{
					trigger_error('IMPORT_SCHEMA_WRITE_FAILED', E_USER_WARNING);
					return;
				}

				// Redirect
				$forward_url = $this->u_action . '&amp;import_schema=' . $import_schema;
				meta_refresh(1, $forward_url);
				trigger_error(sprintf($user->lang['IMPORT_DEBUG_MES'], $done_images, $todo_images));
			}
		}
		else if ($submit)
		{
			if (!check_form_key('acp_gallery'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
				return;
			}
			if (!$images)
			{
				trigger_error('NO_FILE_SELECTED', E_USER_WARNING);
				return;
			}

			$allowed_extensions = $this->get_allowed_extensions();
			$available_images = $this->import_storage->get_images($allowed_extensions);
			$selected_images = [];
			foreach ($images as $image_src)
			{
				if (!is_string($image_src) || !isset($available_images[$image_src]))
				{
					$safe_image_src = is_string($image_src) ? htmlspecialchars($image_src, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '';
					trigger_error($user->lang('IMPORT_INVALID_IMAGE', $safe_image_src), E_USER_WARNING);
					return;
				}
				$selected_images[$image_src] = $image_src;
			}
			$images = array_values($selected_images);

			// Who is the uploader?
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
				$user_id = $user_id[0];
			}
			if (!$user_id)
			{
				$user_id = $user->data['user_id'];
			}

			$sql = 'SELECT username, user_colour, user_id
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $user_id;
			$result = $db->sql_query($sql);
			$user_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			if (!$user_row)
			{
				trigger_error('HACKING_ATTEMPT', E_USER_WARNING);
				return;
			}

			$album_id = $request->variable('album_id', 0);
			if ($request->is_set_post('users_pega'))
			{
				$image_user =  $phpbb_container->get('phpbbgallery.core.user');
				$image_user->set_user_id($user_row['user_id']);
				if ($user->data['user_id'] != $user_row['user_id'])
				{
					$album_id = $image_user->get_data('personal_album_id');
					if (!$album_id)
					{
						// The User has no personal album
						$album_id = $gallery_album->generate_personal_album($user_row['username'], $user_row['user_id'], $user_row['user_colour'], $image_user);
					}
					unset($image_user);
				}
				else
				{
					$album_id = $image_user->get_data('personal_album_id');
					if (!$album_id)
					{
						$album_id = $gallery_album->generate_personal_album($user_row['username'], $user_row['user_id'], $user_row['user_colour'], $image_user);
					}
				}
			}

			// Where do we put them to?
			$sql = 'SELECT album_id, album_name
				FROM ' . $table_prefix . 'gallery_albums
				WHERE album_id = ' . (int) $album_id;
			$result = $db->sql_query($sql);
			$album_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			if (!$album_row)
			{
				trigger_error('HACKING_ATTEMPT', E_USER_WARNING);
				return;
			}

			$start_time = time();
			$import_schema = $this->import_storage->create_schema_id();
			$filename = ($request->variable('filename', '') == 'filename') ? true : false;
			$image_name = $request->variable('image_name', '', true);
			$num_offset = max(0, $request->variable('image_num', 0));
			$this->import_errors = [];

			if (!$this->create_import_schema($import_schema, $album_row['album_id'], $user_row, $start_time, $num_offset, 0, count($images), $image_name, $filename, $images))
			{
				trigger_error('IMPORT_SCHEMA_WRITE_FAILED', E_USER_WARNING);
				return;
			}

			$forward_url = $this->u_action . '&amp;import_schema=' . $import_schema;
			meta_refresh(2, $forward_url);
			trigger_error('IMPORT_SCHEMA_CREATED');
		}

		$files = $this->import_storage->get_images($this->get_allowed_extensions());
		foreach ($files as $file)
		{
			$template->assign_block_vars('imagerow', [
				'FILE_NAME' => htmlspecialchars($file['display_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
			]);
		}

		$template->assign_vars([
			'S_IMPORT_IMAGES'				=> true,
			'ACP_GALLERY_TITLE'				=> $user->lang['ACP_IMPORT_ALBUMS'],
			'ACP_GALLERY_TITLE_EXPLAIN'		=> $user->lang['ACP_IMPORT_ALBUMS_EXPLAIN'],
			'L_IMPORT_DIR_EMPTY'			=> sprintf($user->lang['IMPORT_DIR_EMPTY'], $gallery_url->path('import')),
			'S_ALBUM_IMPORT_ACTION'			=> $this->u_action,
			'S_SELECT_IMPORT' 				=> $gallery_album->get_albumbox(false, 'album_id', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
			'U_FIND_USERNAME'				=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=acp_gallery&amp;field=username&amp;select_single=true'),
		]);
	}

	private function create_import_schema(string $import_schema, int $album_id, array $user_row, int $start_time, int $num_offset, int $done_images, int $todo_images, string $image_name, bool $filename, array $images): bool
	{
		global $user;

		$state = [
			'creator_id' => (int) $user->data['user_id'],
			'album_id' => $album_id,
			'start_time' => $start_time,
			'num_offset' => $num_offset,
			'done_images' => $done_images,
			'todo_images' => $todo_images,
			'image_name' => $image_name,
			'filename' => $filename,
			'user_data' => [
				'user_id' => (int) $user_row['user_id'],
				'username' => (string) $user_row['username'],
				'user_colour' => (string) $user_row['user_colour'],
			],
			'images' => array_values($images),
			'errors' => array_values($this->import_errors),
		];

		return $this->import_storage->write_state($import_schema, $state);
	}

	private function log_import_error(string $error): void
	{
		if (count($this->import_errors) < 10000)
		{
			$this->import_errors[] = $error;
		}
	}

	private function get_allowed_extensions(): array
	{
		global $gallery_config;

		$extensions = [];
		if ($gallery_config->get('allow_jpg'))
		{
			$extensions[] = 'jpg';
			$extensions[] = 'jpeg';
		}
		if ($gallery_config->get('allow_png'))
		{
			$extensions[] = 'png';
		}
		if ($gallery_config->get('allow_gif'))
		{
			$extensions[] = 'gif';
		}
		if ($gallery_config->get('allow_webp'))
		{
			$extensions[] = 'webp';
		}

		return $extensions;
	}
}
