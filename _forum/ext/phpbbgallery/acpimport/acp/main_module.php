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

	/** @var array Language keys describing why the last archive could not be unpacked */
	private array $archive_errors = [];

	public function main(string $id, string $mode): void
	{
		global $auth, $cache, $config, $db, $template, $user, $phpbb_root_path, $phpbb_container, $gallery_url, $gallery_config, $gallery_album;

		$gallery_url = $phpbb_container->get('phpbbgallery.core.url');
		$gallery_config = $phpbb_container->get('phpbbgallery.core.config');
		$gallery_album = $phpbb_container->get('phpbbgallery.core.album');
		$gallery_url->_include('functions_display', 'phpbb');
		$this->import_storage = new import_storage(
			$gallery_url->path('import'),
			$phpbb_container->get('phpbbgallery.core.image.format_registry')
		);
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
		$storage_keys = $phpbb_container->get('phpbbgallery.core.storage.key_generator');
		$local_storage = $phpbb_container->get('phpbbgallery.core.storage.local');
		$storage_workspace = $phpbb_container->get('phpbbgallery.core.storage.workspace');

		// Unpacking an archive is its own action: it only fills the import folder, and
		// the ordinary import below then treats the result like any hand-uploaded image.
		if ($request->is_set_post('extract'))
		{
			if (!check_form_key('acp_gallery'))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				return;
			}

			$this->extract_archives($request->variable('archives', [''], true), 0, 0);
			return;
		}

		if ($request->is_set_post('save_zip_settings'))
		{
			if (!check_form_key('acp_gallery'))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				return;
			}

			$this->save_zip_settings($request->variable('zip_max_images', 0));
			return;
		}

		$pending_archives = $request->variable('extract_pending', [''], true);
		if (!empty($pending_archives))
		{
			$this->extract_archives(
				$pending_archives,
				max(0, $request->variable('extracted_total', 0)),
				max(0, $request->variable('archives_done', 0))
			);
			return;
		}

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
				$staged_source_key = '';
				$display_name = $image_src;
				$safe_image_src = utf8_htmlspecialchars($image_src);
				$image = isset($available_images[$image_src]) ? $available_images[$image_src] : false;
				if ($image === false)
				{
					$this->log_import_error($user->lang('IMPORT_INVALID_IMAGE', $safe_image_src));
					$error_occurred = true;
				}
				else
				{
					$display_name = $image['display_name'];
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
						try
						{
							$image_filename = $storage_keys->create(bin2hex(random_bytes(16)) . $inspection['target_extension']);
							$staged_source_key = 'staging/' . bin2hex(random_bytes(16)) . '/' . basename($image_filename);
						}
						catch (\Throwable)
						{
							$image_filename = '';
						}

						$storage_ready = $image_filename !== '' && $staged_source_key !== ''
							&& $local_storage->prepare(
								\phpbbgallery\core\storage\provider_interface::SOURCE,
								$staged_source_key
							);
						$file_link = $storage_ready
							? $local_storage->local_path(\phpbbgallery\core\storage\provider_interface::SOURCE, $staged_source_key)
							: null;
						if ($file_link === null || !$this->import_storage->copy_image($image_src_full, $file_link))
						{
							$user->add_lang('posting');
							$this->log_import_error(sprintf($user->lang['GENERAL_UPLOAD_ERROR'], (string) $file_link));
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

					$format_registry = $phpbb_container->get('phpbbgallery.core.image.format_registry');
					$external_processor = $format_registry->processor_for_filename($file_link);
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

					if ($external_processor !== null)
					{
						$metadata = $external_processor->prepare_source($file_link, [
							'max_filesize' => (int) $gallery_config->get('max_filesize'),
							'max_width' => (int) $gallery_config->get('max_width'),
							'max_height' => (int) $gallery_config->get('max_height'),
							'allow_resize' => (bool) $gallery_config->get('allow_resize'),
							'rotation' => 0,
						]);
						if ($metadata === null || !$format_registry->accepts_metadata($file_link, $metadata))
						{
							$this->log_import_error($this->language->lang('GENERAL_UPLOAD_ERROR', $display_name));
							$local_storage->delete(
								\phpbbgallery\core\storage\provider_interface::SOURCE,
								$staged_source_key
							);
							continue;
						}
						$filetype = [(int) $metadata['width'], (int) $metadata['height']];
					}
					else if (($filetype[0] > $gallery_config->get('max_width')) || ($filetype[1] > $gallery_config->get('max_height')))
					{
						/**
						* Resize oversize images
						*/
						if ($gallery_config->get('allow_resize'))
						{
							$image_tools->resize_image($gallery_config->get('max_width'), $gallery_config->get('max_height'));
							if ($image_tools->resized)
							{
								if (!$image_tools->write_image($file_link, $gallery_config->get('jpg_quality'), true))
								{
									$this->log_import_error($this->language->lang('GENERAL_UPLOAD_ERROR', $display_name));
									continue;
								}
							}
						}
					}
					$file_updated = $external_processor !== null || (bool) $image_tools->resized;

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
						$sql_ary['image_name'] = str_replace('_', ' ', utf8_substr($display_name, 0, utf8_strrpos($display_name, '.')));
					}
					else
					{
						$sql_ary['image_name'] = str_replace('{NUM}', $num_offset + $done_images, $image_name);
					}
					$sql_ary['image_name_clean'] = utf8_clean_string($sql_ary['image_name']);

					try
					{
						$storage_workspace->publish(
							\phpbbgallery\core\storage\provider_interface::SOURCE,
							$image_filename,
							$file_link
						);
					}
					catch (\RuntimeException)
					{
						$user->add_lang('posting');
						$this->log_import_error(sprintf($user->lang['GENERAL_UPLOAD_ERROR'], $display_name));
						$error_occurred = true;
					}
				}

				if (!$error_occurred)
				{
					try
					{
						// Publish first so the database never points at a missing provider object.
						$db->sql_query('INSERT INTO ' . $table_prefix . 'gallery_images ' . $db->sql_build_array('INSERT', $sql_ary));
						$image_id = (int) $db->sql_nextid();
					}
					catch (\Throwable $exception)
					{
						$storage_workspace->delete(\phpbbgallery\core\storage\provider_interface::SOURCE, $image_filename);
						$local_storage->delete(
							\phpbbgallery\core\storage\provider_interface::SOURCE,
							$staged_source_key
						);
						throw $exception;
					}
					$image_data = ['image_id' => $image_id] + $sql_ary;
					/**
					 * Notify add-ons after an imported image is stored successfully.
					 *
					 * @event phpbbgallery.acpimport.insert_image_after
					 * @var int    image_id   Imported image identifier
					 * @var array  image_data Complete imported image row
					 * @var string file_link  Absolute imported original-image path
					 * @since 1.3.0
					 */
					$vars = ['image_id', 'image_data', 'file_link'];
					extract($phpbb_dispatcher->trigger_event('phpbbgallery.acpimport.insert_image_after', compact($vars)));
					// If the source image is imported, we delete it.
					if (file_exists($image_src_full))
					{
						@unlink($image_src_full);
					}
					$successful_images++;
					$done_images++;
				}
				if ($staged_source_key !== '')
				{
					$local_storage->delete(
						\phpbbgallery\core\storage\provider_interface::SOURCE,
						$staged_source_key
					);
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
			$this->import_errors = [];
			$images = $this->filter_selected_images($images, $available_images);
			if (!$images)
			{
				trigger_error(implode('<br />', $this->import_errors) . adm_back_link($this->u_action), E_USER_WARNING);
				return;
			}
			if (count($images) > import_storage::MAX_IMAGES)
			{
				trigger_error($user->lang('IMPORT_TOO_MANY_IMAGES', import_storage::MAX_IMAGES), E_USER_WARNING);
				return;
			}

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
				$album_id = $image_user->get_data('personal_album_id');
				if (!$album_id)
				{
					// The user has no personal album
					$album_id = $gallery_album->generate_personal_album($user_row['username'], $user_row['user_id'], $user_row['user_colour'], $image_user);
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

			if (!$this->create_import_schema($import_schema, $album_row['album_id'], $user_row, $start_time, $num_offset, 0, count($images), $image_name, $filename, $images))
			{
				trigger_error('IMPORT_SCHEMA_WRITE_FAILED', E_USER_WARNING);
				return;
			}

			$forward_url = $this->u_action . '&amp;import_schema=' . $import_schema;
			meta_refresh(2, $forward_url);
			trigger_error('IMPORT_SCHEMA_CREATED');
		}

		$archives = $this->import_storage->get_archives();
		$files = $this->import_storage->get_images($this->get_allowed_extensions());
		$ignored_unreadable_files = $this->import_storage->get_ignored_unreadable_files();
		foreach ($files as $file)
		{
			$template->assign_block_vars('imagerow', [
				'FILE_NAME' => utf8_htmlspecialchars($file['display_name']),
			]);
		}

		foreach ($archives as $archive)
		{
			$template->assign_block_vars('archiverow', [
				'FILE_NAME' => utf8_htmlspecialchars($archive['display_name']),
			]);
		}

		$template->assign_vars([
			'S_IMPORT_IMAGES'				=> true,
			'ZIP_MAX_IMAGES'				=> $this->get_zip_max_images(),
			'ACP_GALLERY_TITLE'				=> $user->lang['ACP_IMPORT_ALBUMS'],
			'ACP_GALLERY_TITLE_EXPLAIN'		=> $user->lang['ACP_IMPORT_ALBUMS_EXPLAIN'],
			'L_IMPORT_DIR_EMPTY'			=> sprintf($user->lang['IMPORT_DIR_EMPTY'], $gallery_url->path('import')),
			'L_IMPORT_UNREADABLE_FILES'	=> $ignored_unreadable_files ? $user->lang('IMPORT_UNREADABLE_FILES', $ignored_unreadable_files) : '',
			'S_ALBUM_IMPORT_ACTION'			=> $this->u_action,
			'S_SELECT_IMPORT' 				=> $gallery_album->get_albumbox(false, 'album_id', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
			'U_FIND_USERNAME'				=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=acp_gallery&amp;field=username&amp;select_single=true'),
		]);
	}

	/**
	 * Unpack one selected archive per request, carrying the rest forward.
	 *
	 * The archives still sitting in the import folder are the remaining work, so the
	 * queue needs no state file of its own; every pass re-checks the carried names
	 * against a fresh listing rather than trusting what came back in the URL.
	 *
	 * @param array $pending         Archive display names still to unpack
	 * @param int   $extracted_total Images unpacked so far
	 * @param int   $archives_done   Archives unpacked so far
	 * @return void
	 */
	private function extract_archives(array $pending, int $extracted_total, int $archives_done): void
	{
		global $user;

		$available = $this->import_storage->get_archives();

		$queue = [];
		foreach ($pending as $name)
		{
			if (is_string($name) && isset($available[$name]) && !isset($queue[$name]))
			{
				$queue[$name] = $name;
			}
		}
		$queue = array_values($queue);

		if (empty($queue))
		{
			if ($archives_done)
			{
				$this->finish_extraction($extracted_total, $archives_done);
				return;
			}

			trigger_error($user->lang('NO_FILE_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			return;
		}

		$name = array_shift($queue);
		$extracted = $this->extract_archive($available[$name]);

		if ($extracted === false)
		{
			trigger_error(
				$user->lang('IMPORT_ZIP_FAILED', utf8_htmlspecialchars($name))
					. (empty($this->archive_errors) ? '' : '<br /><br />' . implode('<br />', $this->archive_errors))
					. adm_back_link($this->u_action),
				E_USER_WARNING
			);
			return;
		}

		// The archive has given up everything it holds, so it goes.
		@unlink($available[$name]['path']);
		$extracted_total += $extracted;
		$archives_done++;

		if (empty($queue))
		{
			$this->finish_extraction($extracted_total, $archives_done);
			return;
		}

		$forward_url = $this->u_action
			. '&amp;extracted_total=' . $extracted_total
			. '&amp;archives_done=' . $archives_done;
		foreach ($queue as $remaining)
		{
			$forward_url .= '&amp;extract_pending%5B%5D=' . urlencode($remaining);
		}

		meta_refresh(1, $forward_url);
		trigger_error($user->lang('IMPORT_ZIP_EXTRACTED', $extracted, utf8_htmlspecialchars($name)));
	}

	/**
	 * Hand the admin back to the import form with the totals.
	 *
	 * @param int $extracted_total Images unpacked
	 * @param int $archives_done   Archives unpacked
	 * @return void
	 */
	private function finish_extraction(int $extracted_total, int $archives_done): void
	{
		global $user;

		meta_refresh(3, $this->u_action);
		trigger_error($user->lang('IMPORT_ZIP_ALL_EXTRACTED', $extracted_total, $archives_done) . adm_back_link($this->u_action));
	}

	/**
	 * Unpack a single archive into the import folder.
	 *
	 * @param array $archive Archive entry from import_storage::get_archives()
	 * @return int|false Images placed in the import folder, or false
	 */
	private function extract_archive(array $archive): int|false
	{
		global $phpbb_container, $gallery_config, $gallery_url;

		$importer = new archive_importer(
			$this->import_storage,
			$phpbb_container->get('phpbbgallery.core.zip.extractor'),
			$phpbb_container->get('language'),
			$gallery_url->path('import')
		);

		// An unlimited gallery file size would otherwise compute a one-byte entry
		// limit and reject everything.
		$max_filesize = (int) $gallery_config->get('max_filesize');
		if ($max_filesize < 1)
		{
			$max_filesize = \phpbbgallery\core\zip\extractor::MAX_UNCOMPRESSED_SIZE;
		}

		$extracted = $importer->extract($archive, $this->get_allowed_extensions(), $this->get_zip_max_images(), $max_filesize);
		$this->archive_errors = $importer->errors();

		return $extracted;
	}

	/**
	 * Store the per-archive image allowance.
	 *
	 * @param int $max_images Requested allowance
	 * @return void
	 */
	private function save_zip_settings(int $max_images): void
	{
		global $config, $user;

		$config->set('phpbb_gallery_import_zip_max_images', max(1, min($max_images, \phpbbgallery\core\zip\extractor::MAX_ENTRIES)));

		trigger_error($user->lang('IMPORT_ZIP_SETTINGS_SAVED') . adm_back_link($this->u_action));
	}

	/**
	 * Images a single archive may yield.
	 *
	 * An archive can never hold more entries than the extractor inspects, so the
	 * setting is capped there rather than at some larger number that could not be
	 * reached anyway.
	 *
	 * @return int
	 */
	private function get_zip_max_images(): int
	{
		global $config;

		$configured = (int) $config['phpbb_gallery_import_zip_max_images'];

		return max(1, min($configured ?: 1000, \phpbbgallery\core\zip\extractor::MAX_ENTRIES));
	}

	private function filter_selected_images(array $images, array $available_images): array
	{
		global $user;

		$selected_images = [];
		foreach ($images as $image_src)
		{
			if (!is_string($image_src) || !isset($available_images[$image_src]))
			{
				$safe_image_src = is_string($image_src) ? utf8_htmlspecialchars($image_src) : '';
				$this->log_import_error($user->lang('IMPORT_INVALID_IMAGE', $safe_image_src));
				continue;
			}
			$selected_images[$image_src] = $image_src;
		}

		return array_values($selected_images);
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
		global $phpbb_container;

		return $phpbb_container->get('phpbbgallery.core.upload')->get_allowed_types(false, true);
	}
}
