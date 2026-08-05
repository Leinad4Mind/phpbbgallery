<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\icon;

/**
 * List, validate and accept uploads into the album-icon folder.
 *
 * The folder is web-accessible by design - an icon is shown as a plain <img> - so
 * everything here treats it as untrusted once it's on disk: filenames are confined
 * to direct children of the folder the same way the ACP import listing confines
 * itself to its own directory, and an uploaded SVG is parsed and stripped of any
 * script, event handler or embedded HTML before it is ever served.
 */
class manager
{
	private const ALLOWED_EXTENSIONS = ['svg', 'png', 'gif', 'jpg', 'jpeg', 'webp', 'avif'];

	/** Icons are small, curated assets; there is no reason to allow more than this. */
	private const MAX_FILESIZE = 524288;

	/** @var \phpbb\files\upload */
	private object $file_upload;

	/** @var \phpbb\language\language */
	private object $language;

	/** @var string Absolute path to the icons folder, with a trailing separator */
	private string $icons_path;

	/** @var string Root-relative path to the icons folder, no trailing separator */
	private string $icons_path_relative;

	/** @var \phpbbgallery\core\config */
	private \phpbbgallery\core\config $gallery_config;

	/** @var \phpbbgallery\core\image\bmp_processor */
	private \phpbbgallery\core\image\bmp_processor $bmp_processor;

	/**
	 * Constructor
	 *
	 * @param \phpbb\files\upload      $file_upload         phpBB's generic upload service
	 * @param \phpbb\language\language $language            Language object
	 * @param string                   $icons_path           Absolute icons folder path
	 * @param string                   $icons_path_relative Root-relative icons folder path
	 * @param \phpbbgallery\core\config $gallery_config Gallery configuration
	 * @param \phpbbgallery\core\image\bmp_processor $bmp_processor Safe BMP processor
	 */
	public function __construct(\phpbb\files\upload $file_upload, \phpbb\language\language $language, string $icons_path, string $icons_path_relative,
		\phpbbgallery\core\config $gallery_config, \phpbbgallery\core\image\bmp_processor $bmp_processor)
	{
		$this->file_upload = $file_upload;
		$this->language = $language;
		$this->icons_path = rtrim($icons_path, '/\\') . DIRECTORY_SEPARATOR;
		$this->icons_path_relative = rtrim($icons_path_relative, '/\\');
		$this->gallery_config = $gallery_config;
		$this->bmp_processor = $bmp_processor;
	}

	/**
	 * List the icons currently sitting in the folder.
	 *
	 * Direct children only, symlinks refused, real path confined to the folder
	 * itself - the same shape as the ACP import listing's own folder scan.
	 *
	 * @return array Filenames, naturally sorted
	 */
	public function list_icons(): array
	{
		$root_path = realpath($this->icons_path);
		if ($root_path === false || !is_dir($root_path))
		{
			return [];
		}

		$files = @scandir($root_path);
		if ($files === false)
		{
			return [];
		}

		$icons = [];
		foreach ($files as $file)
		{
			if ($file === '.' || $file === '..')
			{
				continue;
			}

			$path = $root_path . DIRECTORY_SEPARATOR . $file;
			if (is_link($path) || !is_file($path))
			{
				continue;
			}

			$real_path = realpath($path);
			if ($real_path === false || strcasecmp(dirname($real_path), $root_path) !== 0)
			{
				continue;
			}

			$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			if (!in_array($extension, self::ALLOWED_EXTENSIONS, true))
			{
				continue;
			}
			if ($extension === 'avif' && !\phpbbgallery\core\file\file::supports_avif())
			{
				continue;
			}

			$icons[] = $file;
		}

		natcasesort($icons);

		return array_values($icons);
	}

	/**
	 * Whether a filename is really an icon in the folder.
	 *
	 * Used to validate whatever the picker submits before it is trusted anywhere
	 * near an <img src> concatenation.
	 *
	 * @param string $filename Candidate filename
	 * @return bool
	 */
	public function is_valid_icon(string $filename): bool
	{
		return $filename !== '' && in_array($filename, $this->list_icons(), true);
	}

	/**
	 * Root-relative path an accepted icon should be stored as, e.g. for album_image.
	 *
	 * @param string $filename Icon filename
	 * @return string
	 */
	public function relative_path(string $filename): string
	{
		return $this->icons_path_relative . '/' . $filename;
	}

	/**
	 * Accept an uploaded icon file.
	 *
	 * @param string $form_field Form field the file was submitted under
	 * @return array ['error' => string|null, 'filename' => string|null]
	 */
	public function upload(string $form_field): array
	{
		if (!$this->ensure_icons_directory())
		{
			return [
				'error' => $this->language->lang('ICON_STORAGE_UNAVAILABLE', $this->icons_path_relative),
				'filename' => null,
			];
		}

		$this->file_upload->reset_vars();
		$allowed_extensions = self::ALLOWED_EXTENSIONS;
		if ($this->gallery_config->get('allow_bmp') && \phpbbgallery\core\image\bmp_processor::is_supported())
		{
			$allowed_extensions[] = 'bmp';
		}
		if (!\phpbbgallery\core\file\file::supports_avif())
		{
			$allowed_extensions = array_values(array_diff($allowed_extensions, ['avif']));
		}
		$this->file_upload->set_allowed_extensions($allowed_extensions);
		$this->file_upload->set_max_filesize(self::MAX_FILESIZE);
		// The SVG branch below parses and rewrites the file itself, which is a far
		// more precise check than a generic first-256-bytes content sniff.
		$this->file_upload->set_disallowed_content([]);

		$file = $this->file_upload->handle_upload('files.types.form', $form_field);
		if (!is_object($file) || !empty($file->error))
		{
			return ['error' => $this->file_error($file), 'filename' => null];
		}

		$file->clean_filename('real');
		// Dimension/type checking below is our own, precise for both raster and SVG;
		// phpBB's own image check cannot make sense of an SVG at all.
		$moved = $file->move_file($this->icons_path_relative, false, true);
		if ($moved !== true || !empty($file->error))
		{
			return [
				'error' => $this->file_error($file, 'ICON_STORAGE_UNAVAILABLE'),
				'filename' => null,
			];
		}

		$destination = realpath((string) $file->get('destination_file'));
		$icons_root = realpath($this->icons_path);
		if ($destination === false
			|| $icons_root === false
			|| strcasecmp(dirname($destination), $icons_root) !== 0)
		{
			return [
				'error' => $this->language->lang('ICON_STORAGE_UNAVAILABLE', $this->icons_path_relative),
				'filename' => null,
			];
		}

		$filename = basename(str_replace('\\', '/', $destination));
		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		if ($extension === 'bmp')
		{
			return $this->convert_bmp_icon($destination, $filename);
		}

		$valid = ($extension === 'svg')
			? $this->sanitize_svg($destination)
			: $this->is_allowed_raster_image($destination, $extension);

		if (!$valid)
		{
			@unlink($destination);

			return ['error' => $this->language->lang('ICON_INVALID_TYPE'), 'filename' => null];
		}

		return ['error' => null, 'filename' => $filename];
	}

	/** Convert an accepted BMP icon to a browser-safe WebP file. */
	private function convert_bmp_icon(string $source, string $filename): array
	{
		$metadata = $this->bmp_processor->inspect($source);
		$webp_filename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
		$destination = dirname($source) . DIRECTORY_SEPARATOR . $webp_filename;
		if ($metadata === null || $this->bmp_processor->create_derivative(
			$source,
			$destination,
			min(1024, (int) $metadata['width']),
			min(1024, (int) $metadata['height']),
			82
		) === null || !@unlink($source))
		{
			if (is_file($source) && !is_link($source))
			{
				@unlink($source);
			}
			if (is_file($destination) && !is_link($destination))
			{
				@unlink($destination);
			}

			return ['error' => $this->language->lang('ICON_INVALID_TYPE'), 'filename' => null];
		}
		@chmod($destination, 0644);

		return ['error' => null, 'filename' => $webp_filename];
	}

	/**
	 * Join whatever phpBB's own upload pipeline reported into one string.
	 *
	 * @param mixed $file filespec instance, or a non-object on total failure
	 * @return string
	 */
	private function file_error(mixed $file, string $fallback = 'ICON_INVALID_TYPE'): string
	{
		if (is_object($file) && !empty($file->error))
		{
			return implode('<br />', $file->error);
		}

		return $fallback === 'ICON_STORAGE_UNAVAILABLE'
			? $this->language->lang($fallback, $this->icons_path_relative)
			: $this->language->lang($fallback);
	}

	/**
	 * Ensure the fixed Gallery icon directory exists and cannot be a symlink.
	 */
	private function ensure_icons_directory(): bool
	{
		$directory = rtrim($this->icons_path, '/\\');
		if (is_link($directory) || (file_exists($directory) && !is_dir($directory)))
		{
			return false;
		}
		if (!is_dir($directory))
		{
			$parent = realpath(dirname($directory));
			if ($parent === false || !is_dir($parent) || !is_writable($parent) || !@mkdir($directory, 0755))
			{
				return false;
			}
		}
		if (!is_writable($directory))
		{
			return false;
		}

		$index = $directory . DIRECTORY_SEPARATOR . 'index.htm';
		if (!file_exists($index)
			&& @file_put_contents($index, "<html>\n<head><title></title></head>\n<body></body>\n</html>\n") === false)
		{
			return false;
		}

		return true;
	}

	/**
	 * Verify a raster upload's content actually matches its extension.
	 *
	 * @param string $path      Path to the saved file
	 * @param string $extension Claimed extension
	 * @return bool
	 */
	private function is_allowed_raster_image(string $path, string $extension): bool
	{
		$image_info = @getimagesize($path);
		if ($image_info === false || !isset($image_info[2]))
		{
			return false;
		}

		$image_types = [
			IMAGETYPE_GIF => ['gif'],
			IMAGETYPE_JPEG => ['jpg', 'jpeg'],
			IMAGETYPE_PNG => ['png'],
			IMAGETYPE_WEBP => ['webp'],
			IMAGETYPE_AVIF => ['avif'],
		];

		return isset($image_types[$image_info[2]]) && in_array($extension, $image_types[$image_info[2]], true);
	}

	/**
	 * Strip anything an SVG could use to run script once opened as a bare document,
	 * and write the cleaned markup back over the file.
	 *
	 * A file that does not even parse as XML is treated as invalid rather than saved.
	 *
	 * @param string $path Path to the saved file
	 * @return bool
	 */
	private function sanitize_svg(string $path): bool
	{
		$contents = @file_get_contents($path);
		if ($contents === false || trim($contents) === '')
		{
			return false;
		}

		$previous_errors = libxml_use_internal_errors(true);
		$document = new \DOMDocument();
		$loaded = $document->loadXML($contents, LIBXML_NONET);
		libxml_clear_errors();
		libxml_use_internal_errors($previous_errors);

		if (!$loaded || $document->documentElement === null || strtolower($document->documentElement->localName) !== 'svg')
		{
			return false;
		}

		foreach (['script', 'foreignObject'] as $tag_name)
		{
			$nodes = $document->getElementsByTagNameNS('*', $tag_name);
			for ($index = $nodes->length - 1; $index >= 0; $index--)
			{
				$node = $nodes->item($index);
				$node->parentNode?->removeChild($node);
			}
		}

		$xpath = new \DOMXPath($document);
		foreach ($xpath->query('//@*') as $attribute)
		{
			$name = strtolower($attribute->nodeName);
			$value = trim((string) $attribute->nodeValue);

			if (strncmp($name, 'on', 2) === 0 || stripos($value, 'javascript:') === 0)
			{
				$attribute->ownerElement?->removeAttribute($attribute->nodeName);
			}
		}

		$sanitized = $document->saveXML();

		return $sanitized !== false && @file_put_contents($path, $sanitized) !== false;
	}
}
