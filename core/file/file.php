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

namespace phpbbgallery\core\file;

/**
 * A little class for all the actions that the gallery does on images.
*
* resize, rotate, watermark, crete thumbnail, write to hdd, send to browser
 *
 */
class file
{
	public const THUMBNAIL_INFO_HEIGHT = 16;
	public const GDLIB1 = 1;
	public const GDLIB2 = 2;
	// Decompression-bomb guard: GD must allocate the full pixel buffer before it can resize
	// anything down, so a file whose declared dimensions exceed this is rejected before decode,
	// regardless of the configured max_width/max_height (which only bound the *output* size).
	public const MAX_DECODE_PIXELS = 40000000;

	public int $chmod = 0644;

	public array $errors = [];
	private bool $browser_cache = true;
	private int $last_modified = 0;

	/** @var \phpbb\request\request_interface */
	private \phpbb\request\request_interface $request;

	/** @var \phpbbgallery\core\url */
	private \phpbbgallery\core\url $url;

	public int $gd_version = 0;

	/** @var \phpbbgallery\core\config */
	public \phpbbgallery\core\config $gallery_config;

	/** @var resource|\GdImage|false|null */
	public mixed $image = null;
	public string $image_content_type = '';
	public string $image_name = '';
	public int $image_quality = 100;
	public array $image_size = [];
	public string $image_source = '';
	public string $image_type = '';

	public int $max_file_size = 0;
	public int $max_height = 0;
	public int $max_width = 0;

	public bool $resized = false;
	public bool $rotated = false;

	public int $thumb_height = 0;
	public int $thumb_width = 0;

	/** @var resource|\GdImage|false|null */
	public mixed $watermark = null;
	public array $watermark_size = [];
	public string $watermark_source = '';
	public bool $watermarked = false;

	/**
	 * Constructor - init some basic stuff
	 *
	 * @param \phpbb\request\request_interface $request
	 * @param \phpbbgallery\core\url $url
	 * @param \phpbbgallery\core\config $gallery_config
	 * @param int $gd_version
	 */
	public function __construct(\phpbb\request\request_interface $request, \phpbbgallery\core\url $url, \phpbbgallery\core\config $gallery_config, int $gd_version)
	{
		$this->request = $request;
		$this->url = $url;
		$this->gallery_config = $gallery_config;
		$this->gd_version = $gd_version;
	}

	public function set_image_options(int $max_file_size, int $max_height, int $max_width): void
	{
		$this->max_file_size = $max_file_size;
		$this->max_height = $max_height;
		$this->max_width = $max_width;
	}

	public function set_image_data(string $source = '', string $name = '', int $size = 0, bool $force_empty_image = false): void
	{
		if ($source)
		{
			$this->image_source = $source;
		}
		if ($name)
		{
			$this->image_name = $name;
		}
		if ($size)
		{
			$this->image_size['file'] = $size;
		}
		if ($force_empty_image)
		{
			$this->image = null;
			$this->watermarked = false;
			$this->rotated = false;
			$this->resized = false;
		}
	}

	/**
	 * Get image mimetype by filename
	 *
	 * Only use this, if the image is secure. As we created all these images, they should be...
	 * @param $filename
	 * @return string
	 */
	public static function mimetype_by_filename(string $filename): string
	{
		switch (substr(strtolower($filename), -4))
		{
			case '.png':
				return 'image/png';
			break;
			case '.gif':
				return 'image/gif';
			break;
			case 'jpeg':
			case '.jpg':
				return 'image/jpeg';
			break;
			case 'webp':
				return 'image/webp';
			break;
		}

		return '';
	}

	public static function extension_by_filename(string $filename): string
	{
		switch (substr(strtolower($filename), -4))
		{
			case '.png':
				return 'png';
			break;
			case '.gif':
				return 'gif';
			break;
			case 'jpeg':
			case '.jpg':
				return 'jpg';
			break;
			case 'webp':
				return 'webp';
			break;
		}

		return '';
	}

	/**
	 * Read image
	 * @param bool $force_filesize
	 * @return bool
	 */
	public function read_image(bool $force_filesize = false): bool
	{
		if (!file_exists($this->image_source))
		{
			return false;
		}

		$file_size = 0;
		if (isset($this->image_size['file']))
		{
			$file_size = $this->image_size['file'];
		}
		else if ($force_filesize)
		{
			$file_size = @filesize($this->image_source);
		}

		// getimagesize() only parses the header, so it's safe to call before any GD decode.
		$image_size = @getimagesize($this->image_source);
		if ($image_size === false)
		{
			$this->image = false;
			return false;
		}

		$this->image_size['file'] = $file_size;
		$this->image_size['width'] = $image_size[0];
		$this->image_size['height'] = $image_size[1];
		$this->image_content_type = $image_size['mime'];

		if (($image_size[0] * $image_size[1]) > self::MAX_DECODE_PIXELS)
		{
			$this->image = false;
			return false;
		}

		switch ($image_size['mime'])
		{
			case 'image/png':
				$this->image_type = 'png';
				$this->image = @imagecreatefrompng($this->image_source);
			break;
			case 'image/webp':
				$this->image_type = 'webp';
				$this->image = @imagecreatefromwebp($this->image_source);
			break;
			case 'image/gif':
				$this->image_type = 'gif';
				$this->image = @imagecreatefromgif($this->image_source);
			break;
			case 'image/jpeg':
				$this->image_type = 'jpeg';
				$this->image = @imagecreatefromjpeg($this->image_source);
			break;
			default:
				$this->image = false;
			break;
		}

		if ($this->image === false)
		{
			return false;
		}

		if ($this->image_type == 'png')
		{
			imagealphablending($this->image, true); // Set alpha blending on ...
			imagesavealpha($this->image, true); // ... and save alpha blending!
		}

		return true;
	}

	/**
	 * Write image to disk
	 * @param $destination
	 * @param int $quality
	 * @param bool $destroy_image
	 */
	public function write_image(string $destination, int $quality = -1, bool $destroy_image = false): void
	{
		if ($quality == -1)
		{
			$quality = (int) $this->gallery_config->get('jpg_quality');
		}
		switch ($this->image_type)
		{
			case 'jpeg':
				imagejpeg($this->image, $destination, $quality);
			break;
			case 'png':
				imagepng($this->image, $destination);
			break;
			case 'webp':
				imagewebp($this->image, $destination);
			break;
			case 'gif':
				imagegif($this->image, $destination);
			break;
		}
		@chmod($destination, $this->chmod);

		if ($destroy_image)
		{
			imagedestroy($this->image);
		}
	}

	/**
	 * Get a browser friendly UTF-8 encoded filename
	 *
	 * @param $file
	 * @return string
	 */
	public function header_filename(string $file): string
	{
		$raw = (string) $this->request->server('HTTP_USER_AGENT');
		$user_agent = htmlspecialchars($raw);

		// There be dragons here.
		// Not many follows the RFC...
		if (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Safari') !== false || strpos($user_agent, 'Konqueror') !== false)
		{
			return 'filename=' . rawurlencode($file);
		}

		// follow the RFC for extended filename for the rest
		return "filename*=UTF-8''" . rawurlencode($file);
	}

	/**
	* We need to disable the "last-modified" caching for guests and in cases of image-errors,
	* so that they can view them, if they logged in or the error was fixed.
	*/
	public function disable_browser_cache(): void
	{
		$this->browser_cache = false;
	}

	/**
	 * Collect the last timestamp where something changed.
	 * This must contain:
	 *    - Last change of the file
	 *    - Last change of user's permissions
	 *    - Last change of user's groups
	 *    - Last change of watermark config
	 *    - Last change of watermark file
	 * @param $timestamp
	 */
	public function set_last_modified(int $timestamp): void
	{
		$this->last_modified = max($timestamp, $this->last_modified);
	}

	/**
	 * Apply private conditional caching without exposing protected images to shared caches.
	 *
	 * @param object $response
	 * @return object
	 */
	public function apply_browser_cache(object $response): object
	{
		if (!$this->browser_cache || $this->last_modified <= 0)
		{
			$response->setPrivate();
			$response->headers->set('Cache-Control', 'private, no-store, no-cache, must-revalidate');
			$response->headers->set('Pragma', 'no-cache');
			$response->headers->set('Expires', '0');

			return $response;
		}

		$response->setPrivate();
		$response->setMaxAge(0);
		$response->headers->addCacheControlDirective('must-revalidate');
		$response->headers->remove('Pragma');
		$response->headers->remove('Expires');
		$response->setLastModified((new \DateTime())->setTimestamp((int) $this->last_modified));

		$request_method = strtoupper((string) $this->request->server('REQUEST_METHOD', 'GET'));
		$if_modified_since = trim((string) $this->request->server('HTTP_IF_MODIFIED_SINCE', ''));
		if (!in_array($request_method, ['GET', 'HEAD'], true) || $if_modified_since === '')
		{
			return $response;
		}

		$if_modified_since = preg_replace('/;.*$/', '', $if_modified_since);
		$modified_since = strtotime($if_modified_since);
		if ($modified_since !== false && $modified_since >= $this->last_modified)
		{
			$response->setNotModified();
		}

		return $response;
	}

	public static function is_ie_greater7(string $browser): bool
	{
		return (bool) preg_match('/msie (\d{2,3}|[89]+).[0-9.]*;/', strtolower($browser));
	}

	public function create_thumbnail(int $max_width, int $max_height, bool $print_details = false, int $additional_height = 0, array $image_size = []): void
	{
		$this->resize_image($max_width, $max_height, (($print_details) ? $additional_height : 0));

		// Create image details credits to Dr.Death
		if ($print_details && sizeof($image_size))
		{
			$dimension_font = 1;
			$dimension_string = $image_size['width'] . 'x' . $image_size['height'] . '(' . intval($image_size['file'] / 1024) . 'KiB)';
			$dimension_colour = imagecolorallocate($this->image, 255, 255, 255);
			$dimension_height = imagefontheight($dimension_font);
			$dimension_width = imagefontwidth($dimension_font) * strlen($dimension_string);
			$dimension_x = ($this->image_size['width'] - $dimension_width) / 2;
			$dimension_y = $this->image_size['height'] + (($additional_height - $dimension_height) / 2);
			$black_background = imagecolorallocate($this->image, 0, 0, 0);
			imagefilledrectangle($this->image, 0, $this->thumb_height, $this->thumb_width, $this->thumb_height + $additional_height, $black_background);
			imagestring($this->image, 1, $dimension_x, $dimension_y, $dimension_string, $dimension_colour);
		}
	}

	public function resize_image(int $max_width, int $max_height, int $additional_height = 0): void
	{
		if (!$this->image)
		{
			$this->read_image();
			if (!$this->image)
			{
				return;
			}
		}

		if (($this->image_size['height'] <= $max_height) && ($this->image_size['width'] <= $max_width))
		{
			// image is small enough, nothing to do here.
			return;
		}

		if (($this->image_size['height'] / $max_height) > ($this->image_size['width'] / $max_width))
		{
			$this->thumb_height	= $max_height;
			$this->thumb_width	= (int) round($max_width * (($this->image_size['width'] / $max_width) / ($this->image_size['height'] / $max_height)));
		}
		else
		{
			$this->thumb_height	= (int) round($max_height * (($this->image_size['height'] / $max_height) / ($this->image_size['width'] / $max_width)));
			$this->thumb_width	= $max_width;
		}

		$image_copy = (($this->gd_version == self::GDLIB1) ? @imagecreate($this->thumb_width, $this->thumb_height + $additional_height) : @imagecreatetruecolor($this->thumb_width, $this->thumb_height + $additional_height));
		if ($this->image_type != 'jpeg')
		{
			imagealphablending($image_copy, false);
			imagesavealpha($image_copy, true);
			$transparent = imagecolorallocatealpha($image_copy, 255, 255, 255, 127);
			imagefilledrectangle($image_copy, 0, 0, $this->thumb_width, $this->thumb_height + $additional_height, $transparent);
		}

		$resize_function = ($this->gd_version == self::GDLIB1) ? 'imagecopyresized' : 'imagecopyresampled';
		$resize_function($image_copy, $this->image, 0, 0, 0, 0, $this->thumb_width, $this->thumb_height, $this->image_size['width'], $this->image_size['height']);

		imagealphablending($image_copy, true);
		imagesavealpha($image_copy, true);
		$this->image = $image_copy;

		$this->image_size['height'] = $this->thumb_height;
		$this->image_size['width'] = $this->thumb_width;

		$this->resized = true;
	}

	/**
	 * Rotate the image
	 * Usage optimized for 0º, 90º, 180º and 270º because of the height and width
	 *
	 * @param $angle
	 * @param $ignore_dimensions
	 */
	public function rotate_image(int $angle, bool $ignore_dimensions): void
	{
		if (!function_exists('imagerotate'))
		{
			$this->errors[] = ['ROTATE_IMAGE_FUNCTION', $angle];
			return;
		}
		if (($angle <= 0) || (($angle % 90) != 0))
		{
			$this->errors[] = ['ROTATE_IMAGE_ANGLE', $angle];
			return;
		}

		if (!$this->image)
		{
			$this->read_image();
			if (!$this->image)
			{
				return;
			}
		}
		if ((($angle / 90) % 2) == 1)
		{
			// Left or Right, we need to switch the height and width
			if (!$ignore_dimensions && (($this->image_size['height'] > $this->max_width) || ($this->image_size['width'] > $this->max_height)))
			{
				// image would be to wide/high
				if ($this->image_size['height'] > $this->max_width)
				{
					$this->errors[] = ['ROTATE_IMAGE_WIDTH'];
				}
				if ($this->image_size['width'] > $this->max_height)
				{
					$this->errors[] = ['ROTATE_IMAGE_HEIGHT'];
				}
				return;
			}
			$new_width = $this->image_size['height'];
			$this->image_size['height'] = $this->image_size['width'];
			$this->image_size['width'] = $new_width;
		}
		$this->image = imagerotate($this->image, $angle, 0);

		$this->rotated = true;
	}

	/**
	 * Watermark the image:
	 *
	 * @param $watermark_source
	 * @param int $watermark_position summary of the parameters for vertical and horizontal adjustment
	 * @param int $min_height
	 * @param int $min_width
	 */
	public function watermark_image(string $watermark_source, int $watermark_position = 20, int $min_height = 0, int $min_width = 0): void
	{
		$this->watermark_source = $watermark_source;
		if (!$this->watermark_source || !file_exists($this->watermark_source))
		{
			$this->errors[] = ['WATERMARK_IMAGE_SOURCE'];
			return;
		}

		if (!$this->image)
		{
			$this->read_image();
			if (!$this->image)
			{
				return;
			}
		}

		if (($min_height && ($this->image_size['height'] < $min_height)) || ($min_width && ($this->image_size['width'] < $min_width)))
		{
			return;
			//$this->errors[] = ['WATERMARK_IMAGE_DIMENSION'];
		}
		$get_dot = strrpos($this->image_source, '.');
		$get_wm_name = substr_replace($this->image_source, '_wm', $get_dot, 0);
		if (file_exists($get_wm_name))
		{
			$this->image_source = $get_wm_name;
			$this->read_image();
			if (!$this->image)
			{
				return;
			}
		}
		else
		{
			$watermark_size = getimagesize($this->watermark_source);
			if ($watermark_size === false)
			{
				$this->errors[] = ['WATERMARK_IMAGE_IMAGECREATE'];
				return;
			}
			$this->watermark_size = $watermark_size;
			switch ($this->watermark_size['mime'])
			{
				case 'image/png':
					$imagecreate = 'imagecreatefrompng';
					break;
				case 'image/webp':
					$imagecreate = 'imagecreatefromwebp';
					break;
				case 'image/gif':
					$imagecreate = 'imagecreatefromgif';
					break;
				default:
					$imagecreate = 'imagecreatefromjpeg';
					break;
			}

			// Get the watermark as resource.
			if (($this->watermark = $imagecreate($this->watermark_source)) === false)
			{
				$this->errors[] = ['WATERMARK_IMAGE_IMAGECREATE'];
			}

			$phpbb_gallery_constants = new \phpbbgallery\core\constants();
			// Where do we display the watermark? up-left, down-right, ...?
			$dst_x = (($this->image_size['width'] * 0.5) - ($this->watermark_size[0] * 0.5));
			$dst_y = ($this->image_size['height'] - $this->watermark_size[1] - 5);
			if ($watermark_position & $phpbb_gallery_constants::WATERMARK_LEFT)
			{
				$dst_x = 5;
			}
			else if ($watermark_position & $phpbb_gallery_constants::WATERMARK_RIGHT)
			{
				$dst_x = ($this->image_size['width'] - $this->watermark_size[0] - 5);
			}
			if ($watermark_position & $phpbb_gallery_constants::WATERMARK_TOP)
			{
				$dst_y = 5;
			}
			else if ($watermark_position & $phpbb_gallery_constants::WATERMARK_MIDDLE)
			{
				$dst_y = (($this->image_size['height'] * 0.5) - ($this->watermark_size[1] * 0.5));
			}
			imagecopy($this->image, $this->watermark, $dst_x, $dst_y, 0, 0, $this->watermark_size[0], $this->watermark_size[1]);
			imagedestroy($this->watermark);
			$this->write_image($get_wm_name);
			$this->image_source = $get_wm_name;
			$this->read_image();
			if (!$this->image)
			{
				return;
			}
		}
		$this->watermarked = true;
	}

	/**
	* Delete file from disc.
	*
	* @param	mixed		$files		String with filename or an array of filenames
	*									Array-Format: $image_id => $filename
	* @param	array		$locations	Array of valid url::path()s where the image should be deleted from
	*/
	public function delete(array|string $files, array $locations = ['thumbnail', 'medium', 'upload']): void
	{
		if (!is_array($files))
		{
			$files = [1 => $files];
		}
		// Let's delete watermarked
		$this->delete_wm($files);
		foreach ($files as $image_id => $file)
		{
			foreach ($locations as $location)
			{
				@unlink($this->url->path($location) . $file);
			}
		}
	}

	/**
	 * @param $files
	 * @param array $locations
	 */
	public function delete_cache(array|string $files, array $locations = ['thumbnail', 'medium']): void
	{
		if (!is_array($files))
		{
			$files = [1 => $files];
		}
		$this->delete_wm($files);
		foreach ($files as $image_id => $file)
		{
			foreach ($locations as $location)
			{
				@unlink($this->url->path($location) . $file);
			}
		}
	}

	/**
	 * @param $files
	 */
	public function delete_wm(array|string $files): void
	{
		$locations = ['upload', 'medium'];
		if (!is_array($files))
		{
			$files = [1 => $files];
		}
		foreach ($files as $image_id => $file)
		{
			$get_dot = strrpos($file, '.');
			$get_wm_name = substr_replace($file, '_wm', $get_dot, 0);
			foreach ($locations as $location)
			{
				@unlink($this->url->path($location) . $get_wm_name);
			}
		}
	}
}
