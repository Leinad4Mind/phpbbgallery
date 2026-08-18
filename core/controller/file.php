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

class file
{
	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language Gallery language service */
	protected \phpbb\language\language $language;

	/** @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $auth;

	/** @var \phpbbgallery\core\user */
	protected \phpbbgallery\core\user $gallery_user;

	/** @var string */
	protected string $path_source;

	/** @var string */
	protected string $path_medium;

	/** @var string */
	protected string $path_mini;

	/** @var string */
	protected string $path_watermark;

	/** @var string Gallery error-image directory */
	protected string $path_error;

	/** @var \phpbbgallery\core\file\file */
	protected \phpbbgallery\core\file\file $tool;

	/** @var \phpbb\request\request_interface */
	protected \phpbb\request\request_interface $request;

	/** @var \phpbb\event\dispatcher_interface Source-access extension dispatcher */
	protected \phpbb\event\dispatcher_interface $dispatcher;

	/** Active-provider workspace; null only for legacy direct construction. */
	protected ?\phpbbgallery\core\storage\workspace $storage_workspace = null;

	/** Trusted image formats supplied by enabled Gallery add-ons. */
	protected ?\phpbbgallery\core\image\format_registry $format_registry = null;

	/** Resolve source keys to the concrete key used by each variant. */
	protected ?\phpbbgallery\core\storage\variant_key $variant_key = null;

	/** Gallery engagement statistics. */
	protected \phpbbgallery\core\statistics $statistics;

	/** Lease for the provider object currently used by the response. */
	protected ?\phpbbgallery\core\storage\local_object $image_object = null;

	/** Lease for a temporary browser-safe source prepared for the response. */
	protected ?\phpbbgallery\core\storage\local_object $response_object = null;

	/** Provider variant requested by the current route. */
	protected string $storage_variant = \phpbbgallery\core\storage\provider_interface::SOURCE;

	/** @var string */
	protected string $table_albums;

	/** @var string */
	protected string $table_images;

	/** @var string */
	protected string $path = '';

	/** @var array */
	protected array $data = [];

	/** @var string */
	protected string $error = '';

	/** @var string */
	protected string $image_src = '';

	/** @var boolean */
	protected bool $use_watermark = false;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config $config Config object
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db Database object
	 * @param \phpbb\user $user User object
	 * @param \phpbb\language\language $language Language service
	 * @param \phpbbgallery\core\auth\auth $gallery_auth Gallery auth object
	 * @param \phpbbgallery\core\user $gallery_user Gallery user object
	 * @param \phpbbgallery\core\file\file $tool
	 * @param \phpbb\request\request_interface $request
	 * @param \phpbb\event\dispatcher_interface $dispatcher
	 * @param \phpbbgallery\core\storage\workspace $storage_workspace
	 * @param \phpbbgallery\core\statistics $statistics
	 * @param string $source_path
	 * @param string $medium_path
	 * @param string $mini_path
	 * @param string $watermark_file
	 * @param string $albums_table
	 * @param string $images_table
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\language\language $language, \phpbbgallery\core\auth\auth $gallery_auth,
	\phpbbgallery\core\user $gallery_user, \phpbbgallery\core\file\file $tool, \phpbb\request\request_interface $request,
	\phpbb\event\dispatcher_interface $dispatcher, \phpbbgallery\core\storage\workspace $storage_workspace,
	\phpbbgallery\core\image\format_registry $format_registry, \phpbbgallery\core\storage\variant_key $variant_key,
	\phpbbgallery\core\statistics $statistics,
	string $source_path, string $medium_path, string $mini_path,
	string $watermark_file, string $albums_table, string $images_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->language = $language;
		$this->auth = $gallery_auth;
		$this->gallery_user = $gallery_user;
		$this->tool = $tool;
		$this->request = $request;
		$this->dispatcher = $dispatcher;
		$this->storage_workspace = $storage_workspace;
		$this->format_registry = $format_registry;
		$this->variant_key = $variant_key;
		$this->statistics = $statistics;
		$this->path_source = $this->resolve_gallery_path($source_path);
		$this->path_medium = $this->resolve_gallery_path($medium_path);
		$this->path_mini = $this->resolve_gallery_path($mini_path);
		$this->path_watermark = $this->resolve_gallery_path($watermark_file);
		$this->path_error = str_replace('\\', '/', dirname($this->path_watermark)) . '/upload/';
		$this->table_albums = $albums_table;
		$this->table_images = $images_table;
	}

	/**
	* Image File Controller
	*	Route: gallery/image/{image_id}/source
	*
	* @param	int		$image_id
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function source(int $image_id): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return $this->source_response($image_id, false, 'source');
	}

	/**
	 * Deliver an original explicitly as a download after an add-on has
	 * completed its own access workflow.
	 */
	public function source_download(int $image_id): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return $this->source_response($image_id, true, 'download');
	}

	/**
	 * Display an owned orphan during the resumable upload review.
	 *
	 * This deliberately does not use i_download or dispatch the published-source
	 * access event. The file has not been submitted yet and still belongs to the
	 * authenticated uploader. Browser-unsafe originals use the medium derivative.
	 */
	public function upload_preview(int $image_id): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		$this->path = $this->path_source;
		$this->load_data($image_id);
		if (!$this->can_preview_pending_upload())
		{
			throw new \phpbb\exception\http_exception(403, 'NOT_AUTHORISED');
		}

		$use_medium = $this->source_requires_download($this->data['image_filename']);
		$this->storage_variant = $use_medium
			? \phpbbgallery\core\storage\provider_interface::MEDIUM
			: \phpbbgallery\core\storage\provider_interface::SOURCE;
		$this->path = $use_medium ? $this->path_medium : $this->path_source;
		$this->generate_image_src();

		if ($use_medium && !file_exists($this->image_src))
		{
			$this->resize(
				$image_id,
				$this->config['phpbb_gallery_medium_width'],
				$this->config['phpbb_gallery_medium_height'],
				'filesize_medium'
			);
		}
		if ($this->error !== '' || !file_exists($this->image_src))
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_NOT_EXIST');
		}

		$this->tool->set_image_options(
			$this->config['phpbb_gallery_max_filesize'],
			$this->config['phpbb_gallery_max_height'],
			$this->config['phpbb_gallery_max_width']
		);
		$this->tool->set_image_data($this->image_src, $this->data['image_name'], 0, true);
		$this->tool->disable_browser_cache();

		return $this->display();
	}

	/** Check that the current user owns an upload which has not been submitted. */
	protected function can_preview_pending_upload(): bool
	{
		return $this->error === ''
			&& !empty($this->user->data['is_registered'])
			&& (int) $this->data['image_user_id'] === (int) $this->user->data['user_id']
			&& (int) $this->data['image_status'] === (int) \phpbbgallery\core\block::STATUS_ORPHAN;
	}

	/**
	 * Validate source permissions and existence before an add-on displays
	 * access or purchase information.
	 *
	 * @return array Complete image and album row
	 */
	public function authorize_source(int $image_id): array
	{
		$this->auth->load_user_permissions($this->user->data['user_id']);
		$this->path = $this->path_source;
		$this->load_data($image_id);
		$this->storage_variant = \phpbbgallery\core\storage\provider_interface::SOURCE;
		$this->check_auth();
		if ($this->error !== '')
		{
			throw new \phpbb\exception\http_exception(403, 'NOT_AUTHORISED');
		}

		$key = (string) $this->data['image_filename'];
		$exists = $this->storage_workspace !== null
			? $this->storage_workspace->exists(\phpbbgallery\core\storage\provider_interface::SOURCE, $key)
			: file_exists($this->path_source . $key);
		if (!$exists)
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_NOT_EXIST');
		}

		return $this->data;
	}

	/**
	 * Build the original-source response.
	 */
	protected function source_response(int $image_id, bool $force_download, string $delivery_mode): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		$this->auth->load_user_permissions($this->user->data['user_id']);
		$this->path = $this->path_source;
		$this->load_data($image_id);
		$this->storage_variant = \phpbbgallery\core\storage\provider_interface::SOURCE;
		$this->check_auth();
		$this->generate_image_src();
		if ($this->error === '')
		{
			$image_data = $this->data;
			$source_path = $this->image_src;
			/**
			 * Allow add-ons to authorize or account for original-source access.
			 *
			 * A listener may interrupt the request with a login, confirmation or
			 * HTTP exception, or require an attachment response. Medium and thumbnail
			 * routes do not trigger this event.
			 *
			 * @event phpbbgallery.core.file.source_access
			 * @var array image_data Complete image and album row
			 * @var string source_path Absolute original-source path
			 * @var bool force_download Whether an add-on requires a download response
			 * @var string delivery_mode Either source or an add-on-authorized download
			 */
			$vars = ['image_data', 'source_path', 'force_download', 'delivery_mode'];
			extract($this->dispatcher->trigger_event(
				'phpbbgallery.core.file.source_access',
				compact($vars)
			));
			$force_download = (bool) $force_download;
		}

		$this->use_watermark = $this->config['phpbb_gallery_watermark_enabled'] && $this->data['album_watermark'] && !$this->auth->acl_check('i_watermark', $this->data['album_id'], $this->data['album_user_id']);

		$this->tool->set_image_options($this->config['phpbb_gallery_max_filesize'], $this->config['phpbb_gallery_max_height'], $this->config['phpbb_gallery_max_width']);
		$this->tool->set_image_data($this->image_src, $this->data['image_name'], 0, true);
		$external_processor = $this->format_registry?->processor_for_filename($this->data['image_filename']);
		if ($this->error === '' && $external_processor !== null)
		{
			$metadata = $external_processor->inspect($this->image_src);
			if ($metadata === null || !$this->format_registry->accepts_metadata($this->data['image_filename'], $metadata))
			{
				$this->set_error_image('image_not_exist.jpg', $this->language->lang('IMAGE_NOT_EXIST'));
				$this->generate_image_src();
				$this->tool->set_image_data($this->image_src, $this->data['image_name'], 0, true);
			}
			else
			{
				$this->tool->image_content_type = (string) $metadata['mime'];
				$this->tool->image_type = (string) $metadata['extension'];
				if ($this->use_watermark && !$this->prepare_external_watermark_source($external_processor, $metadata))
				{
					$this->set_error_image('image_not_exist.jpg', $this->language->lang('IMAGE_NOT_EXIST'));
					$this->generate_image_src();
					$this->tool->set_image_data($this->image_src, $this->data['image_name'], 0, true);
				}
			}
		}
		// Original-source access may be user-specific; never let the browser or
		// an intermediary reuse a response without passing through authorization.
		$this->tool->disable_browser_cache();

		// The image-page controller owns view counting; browsers may repeat binary requests.
		$response = $this->display(
			$force_download || $this->source_requires_download($this->data['image_filename'])
		);
		if ($this->error === '')
		{
			$this->statistics->record_download((int) $image_id, (int) $this->user->data['user_id']);
		}

		return $response;
	}

	/** Determine whether a source format is unsuitable for inline browser display. */
	protected function source_requires_download(string $filename): bool
	{
		$extension = strtolower((string) pathinfo($filename, PATHINFO_EXTENSION));

		return !in_array($extension, ['gif', 'jpg', 'jpeg', 'png', 'webp', 'avif'], true);
	}

	/**
	 * Convert a browser-unsafe original to a full-size temporary WebP before
	 * applying the Core watermark. Failure must never expose the unwatermarked
	 * source to a user who lacks the watermark-bypass permission.
	 *
	 * @param \phpbbgallery\core\image\external_processor_interface $processor
	 * @param array $metadata Verified original metadata
	 */
	protected function prepare_external_watermark_source(
		\phpbbgallery\core\image\external_processor_interface $processor,
		array $metadata
	): bool
	{
		if ($this->storage_workspace === null)
		{
			return false;
		}

		$temporary = null;
		try
		{
			$temporary = $this->storage_workspace->create_temporary(
				$this->data['image_filename'] . '.watermark.webp'
			);
			$derived = $processor->create_derivative(
				$this->image_src,
				$temporary->get_path(),
				(int) ($metadata['width'] ?? 0),
				(int) ($metadata['height'] ?? 0),
				(int) $this->config['phpbb_gallery_jpg_quality']
			);
			if ($derived === null
				|| strtolower((string) ($derived['extension'] ?? '')) !== 'webp'
				|| strtolower((string) ($derived['mime'] ?? '')) !== 'image/webp'
				|| (int) ($derived['width'] ?? 0) < 1
				|| (int) ($derived['height'] ?? 0) < 1
				|| ((int) $derived['width'] * (int) $derived['height']) > \phpbbgallery\core\file\file::MAX_DECODE_PIXELS
				|| (int) ($derived['filesize'] ?? 0) < 1
				|| !is_file($temporary->get_path())
				|| is_link($temporary->get_path()))
			{
				return false;
			}

			$this->response_object = $temporary;
			$temporary = null;
			$this->tool->set_image_data($this->response_object->get_path(), $this->data['image_name'], 0, true);
			$this->tool->image_content_type = 'image/webp';
			$this->tool->image_type = 'webp';

			return true;
		}
		catch (\Throwable)
		{
			return false;
		}
		finally
		{
			if ($temporary !== null)
			{
				$temporary->release();
			}
		}
	}

	/**
	* Image File Controller
	*	Route: gallery/image/{image_id}/medium
	*
	* @param	int		$image_id
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function medium(int $image_id): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{

		$this->path = $this->path_medium;
		$this->load_data($image_id);
		$this->storage_variant = \phpbbgallery\core\storage\provider_interface::MEDIUM;
		$this->check_auth();

		$this->generate_image_src();

		if (!file_exists($this->image_src))
		{
			$this->resize($image_id, $this->config['phpbb_gallery_medium_width'], $this->config['phpbb_gallery_medium_height'], 'filesize_medium');
			$this->generate_image_src();
		}
		$this->auth->load_user_permissions($this->user->data['user_id']);
		$this->use_watermark = $this->config['phpbb_gallery_watermark_enabled'] && $this->data['album_watermark'] && !$this->auth->acl_check('i_watermark', $this->data['album_id'], $this->data['album_user_id']);
		$this->tool->set_image_options($this->config['phpbb_gallery_max_filesize'], $this->config['phpbb_gallery_max_height'], $this->config['phpbb_gallery_max_width']);
		$this->tool->set_image_data($this->image_src, $this->data['image_name'], 0, true);
		if ($this->error || !$this->user->data['is_registered'])
		{
			$this->tool->disable_browser_cache();
		}

		$this->resize($image_id, $this->config['phpbb_gallery_medium_width'], $this->config['phpbb_gallery_medium_height'], 'filesize_medium');

		return $this->display();
	}

	/**
	* Image File Controller
	*	Route: gallery/image/{image_id}/mini
	*
	* @param	int		$image_id
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function mini(int $image_id): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		$this->path = $this->path_mini;
		$this->load_data($image_id);
		$this->storage_variant = \phpbbgallery\core\storage\provider_interface::MINI;
		$this->check_auth();
		$this->generate_image_src();

		if (!file_exists($this->image_src))
		{
			$this->resize($image_id, $this->config['phpbb_gallery_thumbnail_width'], $this->config['phpbb_gallery_thumbnail_height'], 'filesize_cache');
			$this->generate_image_src();
		}
		$this->tool->set_image_options($this->config['phpbb_gallery_max_filesize'], $this->config['phpbb_gallery_max_height'], $this->config['phpbb_gallery_max_width']);
		$this->tool->set_image_data($this->image_src, $this->data['image_name'], 0, true);
		if ($this->error || !$this->user->data['is_registered'])
		{
			$this->tool->disable_browser_cache();
		}

		$this->resize($image_id, $this->config['phpbb_gallery_thumbnail_width'], $this->config['phpbb_gallery_thumbnail_height'], 'filesize_cache');

		return $this->display();
	}

	public function load_data(int $image_id): void
	{
		$this->data = [];
		$this->error = '';
		$this->image_src = '';
		$this->image_object = null;
		$this->response_object = null;
		$this->storage_variant = \phpbbgallery\core\storage\provider_interface::SOURCE;
		$this->use_watermark = false;

		if ($image_id == 0)
		{
			$this->set_error_image('image_not_exist.jpg', $this->language->lang('IMAGE_NOT_EXIST'));
		}
		else
		{
			$sql = 'SELECT *
				FROM ' . $this->table_images . ' i
				LEFT JOIN ' . $this->table_albums . ' a
					ON (i.image_album_id = a.album_id)
				WHERE i.image_id = ' . (int) $image_id;
			$result = $this->db->sql_query($sql);
			$image_data = $this->db->sql_fetchrow($result);
			$this->data = is_array($image_data) ? $image_data : [];
			$this->db->sql_freeresult($result);

			if (!$this->data || !$this->data['album_id'])
			{
				// Image or album does not exist
				$this->set_error_image('not_authorised.jpg', $this->language->lang('NOT_AUTHORISED'));

			}
		}
	}

	public function check_auth(): void
	{
		$this->auth->load_user_permissions($this->user->data['user_id']);
		if ($this->error !== '')
		{
			return;
		}
		$zebra_array = $this->auth->get_user_zebra($this->user->data['user_id']);
		// Check permissions
		if (($this->data['image_user_id'] != $this->user->data['user_id']) && ($this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_ORPHAN))
		{
			// The image is currently being uploaded
			$this->set_error_image('not_authorised.jpg', $this->language->lang('NOT_AUTHORISED'));
		}
		$can_download_source = $this->storage_variant !== \phpbbgallery\core\storage\provider_interface::SOURCE
			|| $this->auth->acl_check('i_download', $this->data['album_id'], $this->data['album_user_id']);
		if (!$this->auth->acl_check('i_view', $this->data['album_id'], $this->data['album_user_id'])
			|| !$can_download_source
			|| (!$this->auth->acl_check('m_status', $this->data['album_id'], $this->data['album_user_id'])
				&& $this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED
				&& $this->data['image_user_id'] != $this->user->data['user_id'])
			|| ($this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED
				&& !$this->auth->acl_check('m_delete', $this->data['album_id'], $this->data['album_user_id'])))
		{
			// Missing permissions
			$this->set_error_image('not_authorised.jpg', $this->language->lang('NOT_AUTHORISED'));
		}
		if (($this->auth->get_zebra_state($zebra_array, (int) $this->data['album_user_id'], $this->data['album_id']) < (int) $this->data['album_auth_access'] && !$this->error))
		{
			// Zebra parameters not met
			$this->set_error_image('not_authorised.jpg', $this->language->lang('NOT_AUTHORISED'));
		}
	}

	public function generate_image_src(): void
	{
		if ($this->error !== '')
		{
			$this->image_src = $this->get_error_image_src();
			return;
		}

		$key = $this->data['image_filename'];
		$source_exists = $this->storage_workspace !== null
			? $this->storage_workspace->exists(\phpbbgallery\core\storage\provider_interface::SOURCE, $key)
			: file_exists($this->path_source . $key);

		if (!$source_exists)
		{
			if (empty($this->data['image_filemissing']))
			{
				$sql = 'UPDATE ' . $this->table_images . '
					SET image_filemissing = 1
					WHERE image_id = ' . (int) $this->data['image_id'];
				$this->db->sql_query($sql);
			}

			$this->set_error_image('image_not_exist.jpg', $this->language->lang('IMAGE_NOT_EXIST'));
			$this->image_src = $this->get_error_image_src();
			return;
		}

		// A transient path-resolution failure must not leave a valid image permanently missing.
		if (!empty($this->data['image_filemissing']))
		{
			$sql = 'UPDATE ' . $this->table_images . '
				SET image_filemissing = 0
				WHERE image_id = ' . (int) $this->data['image_id'];
			$this->db->sql_query($sql);
			$this->data['image_filemissing'] = 0;
		}

		if ($this->storage_variant !== \phpbbgallery\core\storage\provider_interface::SOURCE)
		{
			$this->check_hot_link();
		}

		// There was a reason to not display the image, so we send an error-image
		if ($this->error)
		{
			$this->image_src = $this->get_error_image_src();
			$this->use_watermark = false;
			return;
		}

		if ($this->storage_workspace === null)
		{
			$this->image_src = $this->path . $key;
			return;
		}

		if (!$this->storage_workspace->exists($this->storage_variant, $key))
		{
			$this->image_src = '';
			return;
		}

		try
		{
			$this->image_object = $this->storage_workspace->materialize($this->storage_variant, $key);
			$this->image_src = $this->image_object->get_path();
		}
		catch (\RuntimeException)
		{
			$this->set_error_image('image_not_exist.jpg', $this->language->lang('IMAGE_NOT_EXIST'));
			$this->image_src = $this->get_error_image_src();
		}
	}

	/**
	* Image File Controller
	*	Route: gallery/image/{image_id}/x
	*
	* @return \Symfony\Component\HttpFoundation\BinaryFileResponse A Symfony Response object
	*/
	public function display(bool $attachment = false): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		$this->tool->set_last_modified($this->gallery_user->get_data('user_permissions_changed'));
		$this->tool->set_last_modified($this->config['phpbb_gallery_watermark_changed']);

		// Watermark
		if ($this->use_watermark)
		{
			$this->tool->set_last_modified(@filemtime($this->config['phpbb_gallery_watermark_source']));
			$this->tool->watermark_image($this->config['phpbb_gallery_watermark_source'], $this->config['phpbb_gallery_watermark_position'], $this->config['phpbb_gallery_watermark_height'], $this->config['phpbb_gallery_watermark_width']);
		}
		$provider_modified = $this->storage_workspace !== null && $this->error === ''
			? $this->storage_workspace->modified_time($this->storage_variant, $this->data['image_filename'])
			: null;
		$this->tool->set_last_modified($provider_modified ?? (int) @filemtime($this->tool->image_source));

		// Let's check image is loaded
		if (!$this->tool->image_content_type)
		{
			$this->tool->image_content_type = $this->tool->mimetype_by_filename($this->tool->image_source);
			if (!$this->tool->image_content_type)
			{
				trigger_error('NO_MIMETYPE_MATCHED');
			}
		}

		if (!$this->tool->image_type)
		{
			$this->tool->image_type = $this->tool->extension_by_filename($this->tool->image_source);
			if (!$this->tool->image_type)
			{
				trigger_error('NO_EXTENSION_MATCHED');
			}
		}

		$response = new \Symfony\Component\HttpFoundation\BinaryFileResponse($this->tool->image_source);

		$response->headers->set('Content-Type', $this->tool->image_content_type);
		$response->headers->set('X-Content-Type-Options', 'nosniff');
		if ($attachment || empty($this->user->browser) || (!$this->tool->is_ie_greater7($this->user->browser) && (strpos(strtolower($this->user->browser), 'msie') !== false)))
		{
			$response->headers->set('Content-Disposition', 'attachment; ' . $this->tool->header_filename(htmlspecialchars_decode($this->tool->image_name) . '.' . $this->tool->image_type));
			if (empty($this->user->browser) || (strpos(strtolower($this->user->browser), 'msie 6.0') !== false))
			{
				$response->headers->set('expires', '-1');
			}
		}
		else
		{
			$response->headers->set('Content-Disposition', 'inline; ' . $this->tool->header_filename(htmlspecialchars_decode($this->tool->image_name) . '.' . $this->tool->image_type));
			if ($this->tool->is_ie_greater7($this->user->browser))
			{
				$response->headers->set('X-Download-Options', 'noopen');
			}
		}
		$this->tool->apply_browser_cache($response);
		$this->release_response_objects($response);

		return $response;
	}

	/** Release provider leases while preserving the file until Symfony sends it. */
	protected function release_response_objects(\Symfony\Component\HttpFoundation\BinaryFileResponse $response): void
	{
		$response_path = $this->tool->image_source;
		$delete_after_send = false;

		foreach (['response_object', 'image_object'] as $property)
		{
			$object = $this->{$property};
			if ($object === null)
			{
				continue;
			}

			if ($object->is_temporary() && $response_path === $object->get_path())
			{
				$object->detach();
				$delete_after_send = true;
			}
			else
			{
				$delete_after_send = $delete_after_send
					|| ($object->is_temporary() && $this->response_is_watermark_derivative($response_path, $object));
				$object->release();
			}
			$this->{$property} = null;
		}

		if ($delete_after_send)
		{
			$response->deleteFileAfterSend(true);
		}
	}

	/** Determine whether a response is the watermark derivative of a leased file. */
	protected function response_is_watermark_derivative(
		string $response_path,
		\phpbbgallery\core\storage\local_object $object
	): bool
	{
		$object_path = $object->get_path();
		$dot = strrpos($object_path, '.');

		return $dot !== false && $response_path === substr_replace($object_path, '_wm', $dot, 0);
	}

	protected function resize(int $image_id, int $resize_width, int $resize_height, string $store_filesize = '', bool $put_details = false): void
	{
		if (!file_exists($this->image_src))
		{
			$source_object = null;
			$output_object = null;
			$key = $this->data['image_filename'];
			$derived_key = ($this->variant_key ?? new \phpbbgallery\core\storage\variant_key())->resolve($this->storage_variant, $key);
			try
			{
				if ($this->storage_workspace !== null)
				{
					$source_object = $this->storage_workspace->materialize(
						\phpbbgallery\core\storage\provider_interface::SOURCE,
						$key
					);
					$output_object = $this->storage_workspace->create_temporary($derived_key);
					$source_path = $source_object->get_path();
					$output_path = $output_object->get_path();
				}
				else
				{
					$source_path = $this->path_source . $key;
					$output_path = $this->path . $derived_key;
				}

				$external_processor = $this->format_registry?->processor_for_filename($key);
				if ($external_processor !== null)
				{
					$metadata = $external_processor->create_derivative(
						$source_path,
						$output_path,
						$resize_width,
						$resize_height,
						(int) $this->config['phpbb_gallery_jpg_quality']
					);
					if ($metadata === null
						|| ($metadata['extension'] ?? '') !== 'webp'
						|| ($metadata['mime'] ?? '') !== 'image/webp'
						|| (int) ($metadata['width'] ?? 0) < 1
						|| (int) ($metadata['height'] ?? 0) < 1
						|| ((int) $metadata['width'] * (int) $metadata['height']) > \phpbbgallery\core\file\file::MAX_DECODE_PIXELS
						|| (int) ($metadata['filesize'] ?? 0) < 1
						|| !is_file($output_path) || is_link($output_path))
					{
						throw new \RuntimeException('The Gallery external derivative could not be generated.');
					}
				}
				else
				{
					$this->tool->set_image_data($source_path, '', 0, true);
					if (!$this->tool->read_image(true))
					{
						throw new \RuntimeException('The Gallery source image could not be decoded.');
					}

					$image_size = [
						'file' => $this->tool->image_size['file'],
						'width' => $this->tool->image_size['width'],
						'height' => $this->tool->image_size['height'],
					];

					$this->tool->set_image_data($output_path);
					if (($image_size['width'] > $resize_width) || ($image_size['height'] > $resize_height))
					{
						$this->tool->create_thumbnail($resize_width, $resize_height, $put_details, \phpbbgallery\core\file\file::THUMBNAIL_INFO_HEIGHT, $image_size);
					}

					if (!$this->tool->write_image($output_path, $this->config['phpbb_gallery_jpg_quality'], false)
						|| !is_file($output_path) || is_link($output_path))
					{
						throw new \RuntimeException('The Gallery derived image could not be generated.');
					}
				}
				$generated_size = @filesize($output_path);

				if ($this->storage_workspace !== null)
				{
					try
					{
						$this->storage_workspace->publish($this->storage_variant, $key, $output_path);
					}
					catch (\RuntimeException $exception)
					{
						// Another authorized request may have published the same cache first.
						if (!$this->storage_workspace->exists($this->storage_variant, $key))
						{
							throw $exception;
						}
					}
					$output_object->release();
					$source_object->release();
					$this->image_object = $this->storage_workspace->materialize($this->storage_variant, $key);
					$this->image_src = $this->image_object->get_path();
				}
				else
				{
					$this->image_src = $output_path;
				}
			}
			catch (\RuntimeException)
			{
				if ($output_object !== null)
				{
					$output_object->release();
				}
				if ($source_object !== null)
				{
					$source_object->release();
				}
				$this->set_error_image('image_not_exist.jpg', $this->language->lang('IMAGE_NOT_EXIST'));
				$this->generate_image_src();
				return;
			}

			if ($store_filesize)
			{
				$this->data[$store_filesize] = $generated_size === false ? 0 : (int) $generated_size;
				$sql = 'UPDATE ' . $this->table_images . '
					SET ' . $this->db->sql_build_array('UPDATE', [
						$store_filesize => $this->data[$store_filesize],
					]) . '
					WHERE ' . $this->db->sql_in_set('image_id', $image_id);
				$this->db->sql_query($sql);
			}
		}
	}

	/**
	 * Resolve Gallery paths independently of the web server process working directory.
	 *
	 * @param string $path Configured path
	 * @return string
	 */
	private function resolve_gallery_path(string $path): string
	{
		$path = str_replace('\\', '/', $path);
		if (preg_match('#^(?:[a-z]:/|/)#i', $path))
		{
			return $path;
		}

		foreach (['files/phpbbgallery/', 'ext/phpbbgallery/'] as $root_marker)
		{
			$offset = strpos($path, $root_marker);
			if ($offset !== false)
			{
				return str_replace('\\', '/', dirname(__DIR__, 4)) . '/' . substr($path, $offset);
			}
		}

		return $path;
	}

	/**
	 * Get the localized error image when available, otherwise the generic image.
	 *
	 * @return string
	 */
	private function get_error_image_src(): string
	{
		$localized_filename = $this->user->data['user_lang'] . '_' . $this->error;
		if (file_exists($this->path_error . $localized_filename))
		{
			$this->data['image_filename'] = $localized_filename;
			return $this->path_error . $localized_filename;
		}

		$this->data['image_filename'] = $this->error;
		return $this->path_error . $this->error;
	}

	protected function check_hot_link(): void
	{
		if ($this->config['phpbb_gallery_allow_hotlinking'])
		{
			return;
		}

		$allowed_domains = explode(',', $this->config['phpbb_gallery_hotlinking_domains']);
		$allowed_domains[] = $this->config['server_name'];
		$referrer = $this->request->server('HTTP_REFERER', '');
		if ($this->is_allowed_referrer($referrer, $allowed_domains))
		{
			return;
		}

		$this->set_error_image('no_hotlinking.jpg', $this->language->lang('HOTLINK_NOT_ALLOWED'));
	}

	/**
	 * Replace the current image with a complete, safe error-image state.
	 *
	 * @param string $filename Error-image filename
	 * @param string $name     Error-image display name
	 * @return void
	 */
	protected function set_error_image(string $filename, string $name): void
	{
		$this->error = $filename;
		$this->data = array_merge($this->data, [
			'image_id' => (int) ($this->data['image_id'] ?? 0),
			'image_filename' => $filename,
			'image_name' => $name,
			'image_user_id' => 1,
			'image_status' => 2,
			'album_id' => 0,
			'album_user_id' => 1,
			'album_auth_access' => 0,
			'image_filemissing' => 0,
			'album_watermark' => 0,
		]);
	}

	/**
	 * @param string $referrer
	 * @param array  $allowed_domains
	 * @return bool
	 */
	protected function is_allowed_referrer(string $referrer, array $allowed_domains): bool
	{
		$scheme = strtolower((string) parse_url($referrer, PHP_URL_SCHEME));
		$referrer_host = $this->normalize_hotlink_host((string) parse_url($referrer, PHP_URL_HOST));
		if (!in_array($scheme, ['http', 'https'], true) || $referrer_host === '')
		{
			return false;
		}

		foreach ($allowed_domains as $allowed_domain)
		{
			$allowed_host = $this->normalize_hotlink_host($allowed_domain);
			if ($allowed_host === '')
			{
				continue;
			}

			$allow_subdomains = !filter_var($allowed_host, FILTER_VALIDATE_IP);
			if ($referrer_host === $allowed_host || ($allow_subdomains && substr($referrer_host, -(strlen($allowed_host) + 1)) === '.' . $allowed_host))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param string $host
	 * @return string
	 */
	protected function normalize_hotlink_host(string $host): string
	{
		$host = trim($host);
		if ($host === '')
		{
			return '';
		}

		if (strpos($host, '://') !== false)
		{
			$host = (string) parse_url($host, PHP_URL_HOST);
		}
		else if (strpos($host, '/') !== false || strpos($host, ':') !== false)
		{
			$host = (string) parse_url('http://' . $host, PHP_URL_HOST);
		}

		$host = strtolower(trim($host, " \t\n\r\0\x0B.[]"));
		if ($host === '' || strlen($host) > 253)
		{
			return '';
		}

		if (filter_var($host, FILTER_VALIDATE_IP))
		{
			return $host;
		}

		if (!preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)*[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?$/D', $host))
		{
			return '';
		}

		return $host;
	}
}
