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

namespace phpbbgallery\core\controller;

use phpbb\request\request_interface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class upload
{
	/** @var request_interface */
	protected request_interface $request;

	/** @var \phpbb\db\driver\driver_interface  */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language  */
	protected \phpbb\language\language $language;

	/** @var \phpbb\template\template  */
	protected \phpbb\template\template $template;

	/** @var \phpbb\config\config  */
	protected \phpbb\config\config $config;

	/** @var ContainerInterface  */
	protected ContainerInterface $phpbb_container;

	/** @var \phpbbgallery\core\misc */
	protected \phpbbgallery\core\misc $misc;

	/** @var \phpbbgallery\core\auth\auth  */
	protected \phpbbgallery\core\auth\auth $auth;

	/** @var \phpbbgallery\core\album\album */
	protected \phpbbgallery\core\album\album $album;

	/** @var \phpbbgallery\core\album\display */
	protected \phpbbgallery\core\album\display $display;

	/** @var \phpbb\controller\helper  */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbbgallery\core\config  */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbbgallery\core\user  */
	protected \phpbbgallery\core\user $gallery_user;

	/** @var \phpbbgallery\core\image\image  */
	protected \phpbbgallery\core\image\image $image;

	/** @var \phpbbgallery\core\url  */
	protected \phpbbgallery\core\url $url;

	/** @var \phpbbgallery\core\upload  */
	protected \phpbbgallery\core\upload $gallery_upload;

	/** @var \phpbbgallery\core\notification  */
	protected \phpbbgallery\core\notification $gallery_notification;

	/** @var \phpbbgallery\core\notification\helper  */
	protected \phpbbgallery\core\notification\helper $notification_helper;

	/** @var \phpbbgallery\core\block  */
	protected \phpbbgallery\core\block $block;

	/** @var \phpbbgallery\core\contest */
	protected \phpbbgallery\core\contest $contest;

	/** @var string */
	protected string $images_table;

	/** @var string */
	protected string $phpbb_root_path;

	/**
	 * Constructor
	 *
	 * @param request_interface                       $request
	 * @param \phpbb\db\driver\driver_interface      $db
	 * @param \phpbb\user                            $user    User object
	 * @param \phpbb\language\language               $language
	 * @param \phpbb\template\template               $template
	 * @param \phpbb\config\config                   $config
	 * @param Container|ContainerInterface           $phpbb_container
	 * @param \phpbbgallery\core\album\album         $album   Album class
	 * @param \phpbbgallery\core\misc                $misc    Misc class
	 * @param \phpbbgallery\core\auth\auth           $auth
	 * @param \phpbbgallery\core\album\display       $display Display class
	 * @param \phpbb\controller\helper               $helper
	 * @param \phpbbgallery\core\config              $gallery_config
	 * @param \phpbbgallery\core\user                $gallery_user
	 * @param \phpbbgallery\core\image\image         $image
	 * @param \phpbbgallery\core\notification        $gallery_notification
	 * @param \phpbbgallery\core\notification\helper $notification_helper
	 * @param \phpbbgallery\core\url                 $url
	 * @param \phpbbgallery\core\upload              $gallery_upload
	 * @param \phpbbgallery\core\block               $block
	 * @param string                                 $images_table
	 * @param string                                 $phpbb_root_path
	 */

	public function __construct(request_interface $request, \phpbb\db\driver\driver_interface $db, \phpbb\user $user,
		\phpbb\language\language $language, \phpbb\template\template $template, \phpbb\config\config $config, ContainerInterface $phpbb_container,
		\phpbbgallery\core\album\album $album, \phpbbgallery\core\misc $misc, \phpbbgallery\core\auth\auth $auth, \phpbbgallery\core\album\display $display,
		\phpbb\controller\helper $helper, \phpbbgallery\core\config $gallery_config, \phpbbgallery\core\user $gallery_user,
		\phpbbgallery\core\image\image $image, \phpbbgallery\core\notification $gallery_notification,
		\phpbbgallery\core\notification\helper $notification_helper, \phpbbgallery\core\url $url,
		\phpbbgallery\core\upload $gallery_upload, \phpbbgallery\core\block $block, \phpbbgallery\core\contest $contest,
		string $images_table, string $phpbb_root_path)
	{
		$this->request = $request;
		$this->db = $db;
		$this->user = $user;
		$this->language = $language;
		$this->template = $template;
		$this->config = $config;
		$this->phpbb_container = $phpbb_container;
		$this->album = $album;
		$this->misc = $misc;
		$this->auth = $auth;
		$this->display = $display;
		$this->helper = $helper;
		$this->gallery_config = $gallery_config;
		$this->gallery_user = $gallery_user;
		$this->image = $image;
		$this->url = $url;
		$this->gallery_upload = $gallery_upload;
		$this->gallery_notification = $gallery_notification;
		$this->notification_helper = $notification_helper;
		$this->block = $block;
		$this->contest = $contest;
		$this->images_table = $images_table;
		$this->phpbb_root_path = $phpbb_root_path;
	}

	public function main(int $album_id): \Symfony\Component\HttpFoundation\Response
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$album_data = $this->album->get_info($album_id);
		$this->display->generate_navigation($album_data);
		add_form_key('gallery');
		$album_backlink = $this->helper->route('phpbbgallery_core_album', ['album_id' => $album_id]);
		$album_loginlink = $this->url->append_sid('phpbb', 'ucp', 'mode=login');
		$error = '';
		//Let's get authorisation
		$this->auth->load_user_permissions($this->user->data['user_id']);
		if (!$this->auth->acl_check('i_upload', $album_id, $album_data['album_user_id']) || ($album_data['album_status'] == $this->block->get_album_status_locked()))
		{
			$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
		}
		if ($album_data['album_type'] == (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			$contest = [];
			$contest = $this->contest->get_contest($album_id, 'album');
			if ($contest['contest_start'] + $contest['contest_rating'] <= time())
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			}
		}
		$page_title = $this->language->lang('UPLOAD_IMAGE') . ' - ' . $album_data['album_name'];

		// Before all
		if (!$this->check_fs())
		{
			trigger_error('NO_WRITE_ACCESS');
		}
		$submit = $this->request->is_set_post('submit');
		$mode = $this->request->variable('mode', 'upload');
		$is_ajax = $this->request->is_ajax();
		$username = '';
		$process = $this->gallery_upload;
		$process->set_up($album_id);

		if ($this->request->is_set_post('discard_pending'))
		{
			if (!check_form_key('gallery'))
			{
				trigger_error('FORM_INVALID');
			}

			$process->discard_pending_images();
			redirect($this->helper->route('phpbbgallery_core_album_upload', ['album_id' => $album_id]));
		}

		// Resume an unfinished draft before accepting another upload for this album.
		if (!$is_ajax && ($mode != 'upload_edit' || !$submit))
		{
			if ($process->load_pending_images())
			{
				$mode = 'upload_edit';
				$submit = false;
			}
			else if ($mode == 'upload_edit')
			{
				$mode = 'upload';
			}
		}

		// So let's see if we have AJAX and use jQuery shit.
		// We are going to use ajax upload only for registered users.
		// Anons should suffer.
		if ($mode == 'upload' && $is_ajax && $this->user->data['is_registered'])
		{
			if (!check_form_key('gallery'))
			{
				return new \Symfony\Component\HttpFoundation\JsonResponse([
					'files' => [
						[
							'error' => $this->language->lang('FORM_INVALID'),
						],
					],
				], 400);
			}

			// So we use ajax request to upload (so we are going to copy some functions from other upload
			// Upload Quota Check
			// 1. Check album-configuration Quota
			if (($this->gallery_config->get('album_images') >= 0) && ($album_data['album_images'] >= $this->gallery_config->get('album_images')))
			{
				//@todo: Add return link
				trigger_error('ALBUM_REACHED_QUOTA');
			}

			// 2. Check user-limit, if he is not allowed to go unlimited
			if (!$this->auth->acl_check('i_unlimited', $album_id, $album_data['album_user_id']))
			{
				$sql = 'SELECT COUNT(image_id) count
					FROM ' . $this->images_table . '
					WHERE image_user_id = ' . (int) $this->user->data['user_id'] . '
						AND image_status <> ' . (int) $this->block->get_image_status_orphan() . '
						AND image_album_id = ' . (int) $album_id;
				$result = $this->db->sql_query($sql);
				$own_images = (int) $this->db->sql_fetchfield('count');
				$this->db->sql_freeresult($result);
				if ($own_images >= $this->auth->acl_check('i_count', $album_id, $album_data['album_user_id']))
				{
					//@todo: Add return link
					trigger_error($this->language->lang('USER_REACHED_QUOTA', $this->auth->acl_check('i_count', $album_id, $album_data['album_user_id'])));
				}
			}

			$upload_files_limit = ($this->auth->acl_check('i_unlimited', $album_id, $album_data['album_user_id'])) ? $this->gallery_config->get('num_uploads') : min(($this->auth->acl_check('i_count', $album_id, $album_data['album_user_id']) - $own_images), $this->gallery_config->get('num_uploads'));
			$process = $this->gallery_upload;
			$process->set_up($album_id, $upload_files_limit);
			$process->set_username($this->user->data['username']);
			$process->set_allow_comments(1);
			$process->upload_file(1);
			if (!empty($process->errors))
			{
				return new \Symfony\Component\HttpFoundation\JsonResponse([
					'files' => [
						[
							'error' => implode(',', $process->errors)
						]
					]
				]);
			}
			$checks = $process->generate_hidden_fields();
			$process->get_images($checks);
			$image_names = [];
			foreach ($process->images as $image_id)
			{
				$image_names[] = $process->image_data[$image_id]['image_name'];
			}
			$process->set_names($image_names);

			$success = true;
			foreach ($process->images as $image_id)
			{
				$success = $success && $process->update_image($image_id, !$this->auth->acl_check('i_approve', $album_id, $album_data['album_user_id']), $album_data['album_contest']);
				if ($this->gallery_user->get_data('watch_own'))
				{
					$this->gallery_notification->add($image_id);
				}
			}

			if ($this->auth->acl_check('i_approve', $album_id, $album_data['album_user_id']))
			{
				$data = [
					'targets'    => [$this->user->data['user_id']],
					'album_id'   => $album_id,
					'last_image' => end($process->images),
				];
				$this->notification_helper->new_image($data);
			}
			else
			{
				$target = [
					'album_id'   => $album_id,
					'last_image' => end($process->images),
					'uploader'   => $this->user->data['user_id'],
				];
				$this->notification_helper->notify('approval', $target);
			}
			$this->image->handle_counter($process->images, true);
			$this->album->update_info($album_id);

			// So if all is fine let's prepare response
			$response = [];
			foreach ($process->images as $image_id)
			{
				$response[] = [
					'url'       => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]),
					'thumbnail' => $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_id]),
					'name'      => $process->image_data[$image_id]['image_name'],
					//	'type'	=> $process->image_data[$process->images[0]]['image_name'],
					'size' => $process->image_data[$image_id]['filesize_upload'],
					//	'delete_url'	=> '',
					//	'delete_type'	=> ''
				];
			}
			return new \Symfony\Component\HttpFoundation\JsonResponse([
				'files' => $response
			]);

		}
		if ($mode == 'upload')
		{
			// Upload Quota Check
			// 1. Check album-configuration Quota
			if (($this->gallery_config->get('album_images') >= 0) && ($album_data['album_images'] >= $this->gallery_config->get('album_images')))
			{
				//@todo: Add return link
				trigger_error('ALBUM_REACHED_QUOTA');
			}

			// 2. Check user-limit, if he is not allowed to go unlimited
			if (!$this->auth->acl_check('i_unlimited', $album_id, $album_data['album_user_id']))
			{
				$sql = 'SELECT COUNT(image_id) count
					FROM ' . $this->images_table . '
					WHERE image_user_id = ' . (int) $this->user->data['user_id'] . '
						AND image_status <> ' . (int) $this->block->get_image_status_orphan() . '
						AND image_album_id = ' . (int) $album_id;
				$result = $this->db->sql_query($sql);
				$own_images = (int) $this->db->sql_fetchfield('count');
				$this->db->sql_freeresult($result);
				if ($own_images >= $this->auth->acl_check('i_count', $album_id, $album_data['album_user_id']))
				{
					//@todo: Add return link
					trigger_error($this->language->lang('USER_REACHED_QUOTA', $this->auth->acl_check('i_count', $album_id, $album_data['album_user_id'])));
				}
			}

			if ($this->misc->display_captcha('upload'))
			{
				$captcha = $this->phpbb_container->get('captcha.factory')->get_instance($this->config['captcha_plugin']);
				$captcha->init(CONFIRM_POST);
				$s_captcha_hidden_fields = '';
				$this->template->assign_vars([
					'S_CONFIRM_CODE'   => true,
					'CAPTCHA_TEMPLATE' => $captcha->get_template(),
				]);

			}

			$upload_files_limit = ($this->auth->acl_check('i_unlimited', $album_id, $album_data['album_user_id'])) ? $this->gallery_config->get('num_uploads') : min(($this->auth->acl_check('i_count', $album_id, $album_data['album_user_id']) - $own_images), $this->gallery_config->get('num_uploads'));
			$process = $this->gallery_upload;
			$process->set_up($album_id, $upload_files_limit);
			if ($submit)
			{
				if (!check_form_key('gallery'))
				{
					trigger_error('FORM_INVALID');
				}
				$process->set_allow_comments($this->request->variable('allow_comments', false, false, request_interface::POST));

				if ($this->misc->display_captcha('upload'))
				{
					$captcha_error = $captcha->validate();
					if ($captcha_error !== false)
					{
						$process->new_error($captcha_error);
					}
				}

				if (!$this->user->data['is_registered'])
				{
					$username = $this->request->variable('username', $this->user->data['username'], true, request_interface::POST);
					if (!function_exists('validate_username'))
					{
						$this->url->_include(['functions_user'], 'phpbb');
					}
					if ($result = validate_username($username))
					{
						$this->language->add_lang('ucp');
						$process->new_error($this->language->lang($result . '_USERNAME'));
					}
					else
					{
						$process->set_username($username);
					}
				}

				if (empty($process->errors))
				{
					$files = $this->request->variable('files', ['name' => ['' => ''], 'type' => ['' => ''], 'tmp_name' => ['' => ''], 'error' => ['' => ''], 'size' => ['' => '']], true, \phpbb\request\request_interface::FILES);
					$count = count($files['name']);
					if ($count <= $upload_files_limit)
					{
						$process->upload_file($count);
					}
				}

				if (!$process->uploaded_files)
				{
					$process->new_error($this->language->lang('UPLOAD_NO_FILE'));
				}
				else
				{
					$mode = 'upload_edit';
					// Remove submit, so we get the first screen of step 2.
					$submit = false;
				}

				$error = implode('<br />', $process->errors);

			}

			if ($mode == 'upload')
			{
				$allowed_extensions = $process->get_allowed_types();
				$this->template->assign_vars([
					'ERROR'               => $error,
					'S_MAX_FILESIZE'      => get_formatted_filesize($this->gallery_config->get('max_filesize')),
					'S_SOURCE_MAX_FILESIZE' => get_formatted_filesize($process->get_source_filesize_limit()),
					'S_RESIZE_LARGE_FILES' => (bool) $this->gallery_config->get('allow_resize') && $process->get_source_filesize_limit() > $this->gallery_config->get('max_filesize'),
					'S_MAX_WIDTH'         => $this->gallery_config->get('max_width'),
					'S_MAX_HEIGHT'        => $this->gallery_config->get('max_height'),
					'S_ALLOWED_FILETYPES' => implode(', ', $process->get_allowed_types(true)),
					'S_ALLOWED_FILETYPES_ACCEPT' => implode(',', array_map(static fn(string $extension): string => '.' . $extension, $allowed_extensions)),
					'S_UPLOAD_FILETYPES_AVAILABLE' => !empty($allowed_extensions),
					'S_ALBUM_ACTION'      => $this->helper->route('phpbbgallery_core_album_upload', ['album_id' => $album_id]),
					'S_UPLOAD'            => true,
					'S_ALLOW_ROTATE'      => ($this->gallery_config->get('allow_rotate') && function_exists('imagerotate')),
					'S_UPLOAD_LIMIT'      => $upload_files_limit,
					'S_COMMENTS_ENABLED'  => $this->gallery_config->get('allow_comments') && $this->gallery_config->get('comment_user_control'),
					'S_ALLOW_COMMENTS'    => true,
					'L_ALLOW_COMMENTS'    => $this->language->lang('ALLOW_COMMENTS_ARY', $upload_files_limit),
				]);

				// Quick upload is restricted to registered users.
				if ($this->user->data['is_registered'] && $allowed_extensions)
				{
					$this->template->assign_vars([
						'S_GALLERY_QUICK_UPLOAD' => true,
						'S_QUICK_MAX_FILESIZE'   => $process->get_source_filesize_limit(),
						'S_QUICK_FILE_TYPES'     => implode('|', array_map('preg_quote', $allowed_extensions)),
					]);
				}
			}
		}
		if ($mode == 'upload_edit')
		{
			if ($submit)
			{
				if (!check_form_key('gallery'))
				{
					trigger_error('FORM_INVALID');
				}

				// Validate quota/description BEFORE deciding whether to finalize, instead of
				// trigger_error()-aborting immediately: the images being finalized here were
				// already inserted as orphan rows in step 1 of this wizard (identified via
				// upload_ids). Aborting here without finalizing them used to strand those rows
				// at STATUS_ORPHAN permanently (recoverable only by resubmitting the exact same
				// upload_ids before the daily cron deletes them). We now always reload them via
				// get_images() below and only skip the finalize/redirect step on validation
				// failure, falling through to redisplay the same review form with the error so
				// the user can correct it without losing the already-uploaded files.
				$validation_error = '';
				$own_images = 0;

				// Upload Quota Check
				// 1. Check album-configuration Quota
				if (($this->gallery_config->get('album_images') >= 0) && ($album_data['album_images'] >= $this->gallery_config->get('album_images')))
				{
					//@todo: Add return link
					$validation_error = $this->language->lang('ALBUM_REACHED_QUOTA');
				}

				// 2. Check user-limit, if he is not allowed to go unlimited
				if (!$this->auth->acl_check('i_unlimited', $album_id, $album_data['album_user_id']))
				{
					$sql = 'SELECT COUNT(image_id) count
						FROM ' . $this->images_table . '
						WHERE image_user_id = ' . (int) $this->user->data['user_id'] . '
							AND image_status <> ' . (int) $this->block->get_image_status_orphan() . '
							AND image_album_id = ' . (int) $album_id;
					$result = $this->db->sql_query($sql);
					$own_images = (int) $this->db->sql_fetchfield('count');
					$this->db->sql_freeresult($result);
					if (!$validation_error && $own_images >= $this->auth->acl_check('i_count', $album_id, $album_data['album_user_id']))
					{
						//@todo: Add return link
						$validation_error = $this->language->lang('USER_REACHED_QUOTA', $this->auth->acl_check('i_count', $album_id, $album_data['album_user_id']));
					}
				}
				$description_array = $this->request->variable('message', [''], true, request_interface::POST);
				if (!$validation_error)
				{
					foreach ($description_array as $var)
					{
						if (strlen($var) > $this->gallery_config->get('description_length'))
						{
							$validation_error = $this->language->lang('DESC_TOO_LONG');
							break;
						}
					}
				}
				$upload_files_limit = ($this->auth->acl_check('i_unlimited', $album_id, $album_data['album_user_id'])) ? $this->gallery_config->get('num_uploads') : min(($this->auth->acl_check('i_count', $album_id, $album_data['album_user_id']) - $own_images), $this->gallery_config->get('num_uploads'));

				$upload_ids = $this->request->variable('upload_ids', [''], false, request_interface::POST);

				$process = $this->gallery_upload;
				$process->set_up($album_id, $upload_files_limit);
				$process->set_rotating($this->request->variable('rotate', [0], false, request_interface::POST));
				$process->get_images($upload_ids);
				if (!$process->images)
				{
					trigger_error('FORM_INVALID');
				}

				$pending_count = count($process->images);
				if (!$validation_error && $this->gallery_config->get('album_images') >= 0 && ($album_data['album_images'] + $pending_count) > $this->gallery_config->get('album_images'))
				{
					$validation_error = $this->language->lang('ALBUM_REACHED_QUOTA');
				}
				if (!$validation_error && $pending_count > $upload_files_limit)
				{
					$validation_error = $this->language->lang('USER_REACHED_QUOTA', $upload_files_limit);
				}

				$image_names = $this->request->variable('image_name', [''], true, request_interface::POST);
				$process->set_names($image_names);
				$process->set_descriptions($description_array);
				$process->set_image_num($this->request->variable('image_num', 0, false, request_interface::POST));
				$process->use_same_name($this->request->variable('same_name', false, false, request_interface::POST));

				if ($validation_error)
				{
					$error = $validation_error;
				}
				else
				{
					$success = true;
					foreach ($process->images as $image_id)
					{
						$success = $success && $process->update_image($image_id, !$this->auth->acl_check('i_approve', $album_id, $album_data['album_user_id']), $album_data['album_contest']);
						if ($this->gallery_user->get_data('watch_own'))
						{
							$this->gallery_notification->add($image_id);
						}
					}

					$message = '';
					$error = implode('<br />', $process->errors);
					if ($this->auth->acl_check('i_approve', $album_id, $album_data['album_user_id']))
					{
						$message .= (!$error) ? $this->language->lang('ALBUM_UPLOAD_SUCCESSFUL') : $this->language->lang('ALBUM_UPLOAD_SUCCESSFUL_ERROR', $error);
						$meta_refresh_time = ($success) ? 3 : 20;
						$data = [
							'targets'    => [$this->user->data['user_id']],
							'album_id'   => (int) $album_id,
							'last_image' => end($process->images),
						];
						$this->notification_helper->new_image($data);
					}
					else
					{
						$target = [
							'album_id'   => (int) $album_id,
							'last_image' => end($process->images),
							'uploader'   => $this->user->data['user_id'],
						];
						$this->notification_helper->notify('approval', $target);
						$message .= (!$error) ? $this->language->lang('ALBUM_UPLOAD_NEED_APPROVAL') : $this->language->lang('ALBUM_UPLOAD_NEED_APPROVAL_ERROR', $error);
						$meta_refresh_time = 20;
					}
					$message .= '<br /><br />' . sprintf($this->language->lang('CLICK_RETURN_ALBUM'), '<a href="' . $album_backlink . '">', '</a>');

					$this->image->handle_counter($process->images, true);
					$this->album->update_info($album_id);

					$this->url->meta_refresh($meta_refresh_time, $album_backlink);
					trigger_error($message);
				}
			}

			$num_images = 0;
			foreach ($process->images as $image_id)
			{
				$data = $process->image_data[$image_id];
				$this->template->assign_block_vars('image', [
					'U_IMAGE'    => $this->image->generate_link('thumbnail', 'plugin', $image_id, $data['image_name'], $album_id),
					'IMAGE_NAME' => $data['image_name'],
					'IMAGE_DESC' => $data['image_desc'],
				]);
				$num_images++;
			}

			$s_hidden_fields = build_hidden_fields([
				'upload_ids' => $process->generate_hidden_fields(),
			]);

			$s_can_rotate = ($this->gallery_config->get('allow_rotate') && function_exists('imagerotate'));
			$this->template->assign_vars([
				'ERROR'          => $error,
				'S_UPLOAD_EDIT'  => true,
				'S_ALLOW_ROTATE' => $s_can_rotate,
				'S_ALBUM_ACTION' => $this->helper->route('phpbbgallery_core_album_upload', ['album_id' => $album_id]),
				'S_USERNAME'     => (!$this->user->data['is_registered']) ? $username : '',
				'NUM_IMAGES'     => $num_images,
				'COLOUR_ROWSPAN' => ($s_can_rotate) ? $num_images * 3 : $num_images * 2,

				'L_DESCRIPTION_LENGTH' => $this->language->lang('DESCRIPTION_LENGTH', $this->gallery_config->get('description_length')),
				'S_HIDDEN_FIELDS'      => $s_hidden_fields,
			]);
		}
		return $this->helper->render('gallery/posting_body.html', $page_title);
	}

	private function check_fs(): bool
	{

		$phpbbgallery_core_file = $this->phpbb_root_path . 'files/phpbbgallery/core';
		$phpbbgallery_core_file_medium = $this->phpbb_root_path . 'files/phpbbgallery/core/medium';
		$phpbbgallery_core_file_mini = $this->phpbb_root_path . 'files/phpbbgallery/core/mini';
		$phpbbgallery_core_file_source = $this->phpbb_root_path . 'files/phpbbgallery/core/source';

		return file_exists($phpbbgallery_core_file) && is_writable($phpbbgallery_core_file)
			&& file_exists($phpbbgallery_core_file_source) && is_writable($phpbbgallery_core_file_source)
			&& file_exists($phpbbgallery_core_file_medium) && is_writable($phpbbgallery_core_file_medium)
			&& file_exists($phpbbgallery_core_file_mini) && is_writable($phpbbgallery_core_file_mini);
	}
}
