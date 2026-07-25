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
	/* @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/* @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/* @var \phpbb\user */
	protected \phpbb\user $user;

	/* @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $auth;

	/* @var \phpbbgallery\core\user */
	protected \phpbbgallery\core\user $gallery_user;

	/* @var string */
	protected string $path_source;

	/* @var string */
	protected string $path_medium;

	/* @var string */
	protected string $path_mini;

	/* @var string */
	protected string $path_watermark;

	/* @var \phpbbgallery\core\file\file */
	protected \phpbbgallery\core\file\file $tool;

	/* @var \phpbb\request\request_interface */
	protected \phpbb\request\request_interface $request;

	/* @var string */
	protected string $table_albums;

	/* @var string */
	protected string $table_images;

	/* @var string */
	protected string $path = '';

	/* @var array */
	protected array $data = [];

	/* @var string */
	protected string $error = '';

	/* @var string */
	protected string $image_src = '';

	/* @var boolean */
	protected bool $use_watermark = false;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config $config Config object
	 * @param \phpbb\db\driver\driver|\phpbb\db\driver\driver_interface $db Database object
	 * @param \phpbb\user $user User object
	 * @param \phpbbgallery\core\auth\auth $gallery_auth Gallery auth object
	 * @param \phpbbgallery\core\user $gallery_user Gallery user object
	 * @param \phpbbgallery\core\file\file $tool
	 * @param \phpbb\request\request_interface $request
	 * @param string $source_path
	 * @param string $medium_path
	 * @param string $mini_path
	 * @param string $watermark_file
	 * @param string $albums_table
	 * @param string $images_table
	 * @internal param \phpbbgallery\core\album\display $display Albums display object
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbbgallery\core\auth\auth $gallery_auth,
	\phpbbgallery\core\user $gallery_user, \phpbbgallery\core\file\file $tool, \phpbb\request\request_interface $request,
	string $source_path, string $medium_path, string $mini_path, string $watermark_file, string $albums_table, string $images_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->auth = $gallery_auth;
		$this->gallery_user = $gallery_user;
		$this->tool = $tool;
		$this->request = $request;
		$this->path_source = $source_path;
		$this->path_medium = $medium_path;
		$this->path_mini = $mini_path;
		$this->path_watermark = $watermark_file;
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
		$this->auth->load_user_permissions($this->user->data['user_id']);
		$this->path = $this->path_source;
		$this->load_data($image_id);
		$this->check_auth();

		if (!file_exists($this->path_source . $this->data['image_filename']))
		{
			$sql = 'UPDATE ' . $this->table_images . '
				SET image_filemissing = 1
				WHERE image_id = ' . (int) $image_id;
			$this->db->sql_query($sql);

			// trigger_error('IMAGE_NOT_EXIST');
			$this->set_error_image('image_not_exist.jpg', 'Image is missing!');
		}

		$this->generate_image_src();
		// @todo Enable watermark

		$this->use_watermark = $this->config['phpbb_gallery_watermark_enabled'] && $this->data['album_watermark'] && !$this->auth->acl_check('i_watermark', $this->data['album_id'], $this->data['album_user_id']);

		$this->tool->set_image_options($this->config['phpbb_gallery_max_filesize'], $this->config['phpbb_gallery_max_height'], $this->config['phpbb_gallery_max_width']);
		$this->tool->set_image_data($this->image_src, $this->data['image_name']);
		if ($this->error || !$this->user->data['is_registered'])
		{
			$this->tool->disable_browser_cache();
		}

		// The image-page controller owns view counting; browsers may repeat binary requests.
		return $this->display();
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
		$this->tool->set_image_data($this->image_src, $this->data['image_name']);
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
		$this->check_auth();
		$this->generate_image_src();

		if (!file_exists($this->image_src))
		{
			$this->resize($image_id, $this->config['phpbb_gallery_thumbnail_width'], $this->config['phpbb_gallery_thumbnail_height'], 'filesize_cache');
			$this->generate_image_src();
		}
		$this->tool->set_image_options($this->config['phpbb_gallery_max_filesize'], $this->config['phpbb_gallery_max_height'], $this->config['phpbb_gallery_max_width']);
		$this->tool->set_image_data($this->image_src, $this->data['image_name']);
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
		$this->use_watermark = false;

		if ($image_id == 0)
		{
			$this->set_error_image('image_not_exist.jpg', 'Image is missing!');
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
				// trigger_error('INVALID_IMAGE');
				$this->set_error_image('not_authorised.jpg', 'You are not authorized!');

			}
		}
	}

	public function check_auth(): void
	{
		$this->auth->load_user_permissions($this->user->data['user_id']);
		$zebra_array = $this->auth->get_user_zebra($this->user->data['user_id']);
		// Check permissions
		if (($this->data['image_user_id'] != $this->user->data['user_id']) && ($this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_ORPHAN))
		{
			// The image is currently being uploaded
			// trigger_error('NOT_AUTHORISED');
			$this->set_error_image('not_authorised.jpg', 'You are not authorized!');
		}
		if (!$this->auth->acl_check('i_view', $this->data['album_id'], $this->data['album_user_id'])
			|| (!$this->auth->acl_check('m_status', $this->data['album_id'], $this->data['album_user_id'])
				&& $this->data['image_status'] == (int) \phpbbgallery\core\block::STATUS_UNAPPROVED
				&& $this->data['image_user_id'] != $this->user->data['user_id']))
		{
			// Missing permissions
			// trigger_error('NOT_AUTHORISED');
			$this->set_error_image('not_authorised.jpg', 'You are not authorized!');
		}
		if (($this->auth->get_zebra_state($zebra_array, (int) $this->data['album_user_id'], $this->data['album_id']) < (int) $this->data['album_auth_access'] && !$this->error))
		{
			// Zebra parameters not met
			// trigger_error('NOT_AUTHORISED');
			$this->set_error_image('not_authorised.jpg', 'You are not authorized!');
		}
	}

	public function generate_image_src(): void
	{
		$this->image_src = $this->path  . $this->data['image_filename'];

		if ($this->data['image_filemissing'] || !file_exists($this->path_source . $this->data['image_filename']))
		{
			$sql = 'UPDATE ' . $this->table_images . '
				SET image_filemissing = 1
				WHERE image_id = ' . (int) $this->data['image_id'];
			$this->db->sql_query($sql);

			// trigger_error('IMAGE_NOT_EXIST');
			$this->set_error_image('image_not_exist.jpg', 'Image is missing!');
		}

		$this->check_hot_link();

		// There was a reason to not display the image, so we send an error-image
		if ($this->error)
		{
			$this->data['image_filename'] = $this->user->data['user_lang'] . '_' . $this->error;
			if (!file_exists($this->path . $this->data['image_filename']))
			{
				$this->data['image_filename'] = $this->error;
			}
			$this->image_src = $this->path . $this->data['image_filename'];
			$this->use_watermark = false;
		}
	}

	/**
	* Image File Controller
	*	Route: gallery/image/{image_id}/x
	*
	* @return \Symfony\Component\HttpFoundation\BinaryFileResponse A Symfony Response object
	*/
	public function display(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		$this->tool->set_last_modified($this->gallery_user->get_data('user_permissions_changed'));
		$this->tool->set_last_modified($this->config['phpbb_gallery_watermark_changed']);

		// Watermark
		if ($this->use_watermark)
		{
			//$this->tool->set_last_modified(@filemtime($this->path_watermark));
			//$this->tool->watermark_image($this->path_watermark, $this->config['phpbb_gallery_watermark_position'], $this->config['phpbb_gallery_watermark_height'], $this->config['phpbb_gallery_watermark_width']);
			$this->tool->set_last_modified(@filemtime($this->config['phpbb_gallery_watermark_source']));
			$this->tool->watermark_image($this->config['phpbb_gallery_watermark_source'], $this->config['phpbb_gallery_watermark_position'], $this->config['phpbb_gallery_watermark_height'], $this->config['phpbb_gallery_watermark_width']);
		}
		$this->tool->set_last_modified(@filemtime($this->tool->image_source));

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
		if ($this->tool->is_ie_greater7($this->user->browser))
		{
			$response->headers->set('X-Content-Type-Options', 'nosniff');
		}
		if (empty($this->user->browser) || (!$this->tool->is_ie_greater7($this->user->browser) && (strpos(strtolower($this->user->browser), 'msie') !== false)))
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

		return $response;
	}

	protected function resize(int $image_id, int $resize_width, int $resize_height, string $store_filesize = '', bool $put_details = false): void
	{
		if (!file_exists($this->image_src))
		{
			$this->tool->set_image_data($this->path_source . $this->data['image_filename']);
			$this->tool->read_image(true);

			$image_size = [
				'file' => $this->tool->image_size['file'],
				'width' => $this->tool->image_size['width'],
				'height' => $this->tool->image_size['height'],
			];

			$this->tool->set_image_data($this->image_src);

			if (($image_size['width'] > $resize_width) || ($image_size['height'] > $resize_height))
			{
				$this->tool->create_thumbnail($resize_width, $resize_height, $put_details, \phpbbgallery\core\file\file::THUMBNAIL_INFO_HEIGHT, $image_size);
			}

//			if ($phpbb_ext_gallery->config->get($mode . '_cache'))
//			{
			$this->tool->write_image($this->image_src, $this->config['phpbb_gallery_jpg_quality'], false);

			if ($store_filesize)
			{
				$this->data[$store_filesize] = @filesize($this->image_src);
				$sql = 'UPDATE ' . $this->table_images . '
					SET ' . $this->db->sql_build_array('UPDATE', [
						$store_filesize => $this->data[$store_filesize],
					]) . '
					WHERE ' . $this->db->sql_in_set('image_id', $image_id);
				$this->db->sql_query($sql);
			}

//			}
		}
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

		$this->set_error_image('no_hotlinking.jpg', 'Hot linking not allowed');
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
