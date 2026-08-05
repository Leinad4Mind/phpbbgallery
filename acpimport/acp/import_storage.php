<?php
/**
 * phpBB Gallery - ACP Import Extension
 *
 * @package   phpbbgallery/acpimport
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\acp;

class import_storage
{
	private const STATE_PREFIX = '.phpbbgallery_import_';
	private const STATE_SUFFIX = '.json';
	private const MAX_STATE_SIZE = 8388608;
	public const MAX_IMAGES = 10000;
	private const MAX_ERRORS = 10000;

	private string $directory;
	private int $ignored_unreadable_files = 0;
	private ?\phpbbgallery\core\image\format_registry $format_registry;

	public function __construct(string $directory, ?\phpbbgallery\core\image\format_registry $format_registry = null)
	{
		$this->directory = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR;
		$this->format_registry = $format_registry;
	}

	public function create_schema_id(): string
	{
		return bin2hex(random_bytes(16));
	}

	/**
	 * @return string|false
	 */
	public function get_state_path(string $schema_id): string|false
	{
		if (!$this->is_valid_schema_id($schema_id))
		{
			return false;
		}

		return $this->directory . self::STATE_PREFIX . $schema_id . self::STATE_SUFFIX;
	}

	public function write_state(string $schema_id, array $state): bool
	{
		$state_path = $this->get_state_path($schema_id);
		if ($state_path === false || !$this->validate_state($state) || !is_dir($this->directory) || is_link($state_path))
		{
			return false;
		}

		$json = json_encode($state, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		if ($json === false || strlen($json) > self::MAX_STATE_SIZE)
		{
			return false;
		}

		$written = @file_put_contents($state_path, $json, LOCK_EX);
		if ($written !== strlen($json))
		{
			return false;
		}

		@chmod($state_path, 0600);
		return true;
	}

	/**
	 * @return array|false
	 */
	public function read_state(string $schema_id): array|false
	{
		$state_path = $this->get_state_path($schema_id);
		if ($state_path === false || is_link($state_path) || !is_file($state_path))
		{
			return false;
		}

		$handle = @fopen($state_path, 'rb');
		if ($handle === false || !flock($handle, LOCK_SH))
		{
			if (is_resource($handle))
			{
				fclose($handle);
			}
			return false;
		}

		$file_data = fstat($handle);
		$state_size = isset($file_data['size']) ? (int) $file_data['size'] : 0;
		if ($state_size < 2 || $state_size > self::MAX_STATE_SIZE)
		{
			flock($handle, LOCK_UN);
			fclose($handle);
			return false;
		}

		$json = '';
		$bytes_read = 0;
		while (!feof($handle))
		{
			$chunk = fread($handle, 8192);
			if ($chunk === false || ($chunk === '' && !feof($handle)))
			{
				$json = false;
				break;
			}
			$bytes_read += strlen($chunk);
			if ($bytes_read > self::MAX_STATE_SIZE)
			{
				$json = false;
				break;
			}
			$json .= $chunk;
		}
		flock($handle, LOCK_UN);
		fclose($handle);
		if ($json === false || strlen($json) !== $state_size)
		{
			return false;
		}

		$state = json_decode($json, true);
		if (!is_array($state) || !$this->validate_state($state))
		{
			return false;
		}

		return $state;
	}

	public function remove_state(string $schema_id): bool
	{
		$state_path = $this->get_state_path($schema_id);
		if ($state_path === false)
		{
			return false;
		}

		if (!file_exists($state_path) && !is_link($state_path))
		{
			return true;
		}

		return @unlink($state_path);
	}

	public function remove_legacy_php_state(): int
	{
		$files = @scandir($this->directory);
		if ($files === false)
		{
			return 0;
		}

		$removed = 0;
		foreach ($files as $file)
		{
			if (!preg_match('/^[a-f0-9]{32}(?:_errors)?\.php$/', $file))
			{
				continue;
			}

			$path = $this->directory . $file;
			if ((is_file($path) || is_link($path)) && @unlink($path))
			{
				$removed++;
			}
		}

		return $removed;
	}

	/**
	 * Return safe, direct child image files indexed by their UTF-8 display name.
	 *
	 * @param array $allowed_extensions
	 * @return array
	 */
	public function get_images(array $allowed_extensions): array
	{
		$this->ignored_unreadable_files = 0;
		$root_path = realpath($this->directory);
		if ($root_path === false || !is_dir($root_path))
		{
			return [];
		}

		$allowed = [];
		foreach ($allowed_extensions as $extension)
		{
			$extension = strtolower((string) $extension);
			if (preg_match('/^[a-z0-9]+$/', $extension))
			{
				$allowed[$extension] = true;
			}
		}

		$files = @scandir($root_path);
		if ($files === false)
		{
			return [];
		}

		$images = [];
		$duplicate_names = [];
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
			if (!isset($allowed[$extension]))
			{
				continue;
			}

			$display_name = $this->get_readable_filename($file);
			if ($display_name === false)
			{
				continue;
			}
			if (isset($duplicate_names[$display_name]))
			{
				continue;
			}

			if (isset($images[$display_name]))
			{
				unset($images[$display_name]);
				$duplicate_names[$display_name] = true;
				continue;
			}

			$images[$display_name] = [
				'display_name' => $display_name,
				'filename' => $file,
				'path' => $real_path,
			];
		}

		uksort($images, 'strnatcasecmp');
		return $images;
	}

	public function get_ignored_unreadable_files(): int
	{
		return $this->ignored_unreadable_files;
	}

	/**
	 * Return the ZIP archives sitting in the import directory.
	 *
	 * Bound the same way images are: direct children only, no symlinks and nothing
	 * whose real path escapes the import root. Directories are skipped, so the
	 * temporary folders a front-end ZIP upload creates never show up here.
	 *
	 * @return array Archives indexed by their UTF-8 display name
	 */
	public function get_archives(): array
	{
		// Listing archives must not disturb the unreadable-file count the caller
		// collects for the image listing, whichever order the two are read in.
		$ignored = $this->ignored_unreadable_files;
		$archives = $this->get_images(['zip']);
		$this->ignored_unreadable_files = $ignored;

		return $archives;
	}

	/**
	 * Turn an archive entry name into a safe, unique direct child of the import folder.
	 *
	 * Nested archive paths are flattened, because both get_images() and copy_image()
	 * only ever accept a direct child. Collisions are resolved rather than allowed:
	 * two files sharing a display name make get_images() drop *both*, so a clash here
	 * would silently lose images.
	 *
	 * @param string $realname Entry basename, already validated by the extractor
	 * @param array  $taken    Names already used, as a name => true map
	 * @return string|false The reserved name, or false when nothing usable remains
	 */
	public function reserve_extracted_name(string $realname, array $taken = []): string|false
	{
		$realname = basename(str_replace('\\', '/', $realname));

		// A leading dot would hide the file and collide with the state-file namespace.
		$realname = ltrim($realname, '.');
		if ($realname === '' || !$this->is_valid_string($realname, 255))
		{
			return false;
		}

		$extension = strtolower(pathinfo($realname, PATHINFO_EXTENSION));
		if (!preg_match('/^[a-z0-9]+$/', $extension))
		{
			return false;
		}

		$stem = substr($realname, 0, -(strlen($extension) + 1));
		if ($stem === '')
		{
			return false;
		}

		for ($suffix = 0; $suffix <= 10000; $suffix++)
		{
			$candidate = $stem . ($suffix ? '_' . $suffix : '') . '.' . $extension;
			if (strlen($candidate) > 255)
			{
				return false;
			}

			if (!isset($taken[$candidate]) && !file_exists($this->directory . $candidate) && !is_link($this->directory . $candidate))
			{
				return $candidate;
			}
		}

		return false;
	}

	/**
	 * @return array|false
	 */
	public function resolve_image(string $display_name, array $allowed_extensions): array|false
	{
		if (!$this->is_valid_string($display_name, 4096))
		{
			return false;
		}

		$images = $this->get_images($allowed_extensions);
		return isset($images[$display_name]) ? $images[$display_name] : false;
	}

	/**
	 * @return array
	 */
	public function inspect_image(array $image): array
	{
		if (!isset($image['path'], $image['filename']) || !is_string($image['path']) || !is_string($image['filename']))
		{
			return ['error' => 'invalid_type'];
		}

		$extension = strtolower(pathinfo($image['filename'], PATHINFO_EXTENSION));
		$processor = $this->format_registry?->processor_for_filename($image['path']);
		if ($processor !== null)
		{
			$metadata = $processor->inspect($image['path']);
			if ($metadata === null || !$this->format_registry->accepts_metadata($image['path'], $metadata))
			{
				return ['error' => 'invalid_type'];
			}

			return [
				'error' => '',
				'image_info' => [
					0 => (int) $metadata['width'],
					1 => (int) $metadata['height'],
					'mime' => (string) $metadata['mime'],
				],
				'target_extension' => '.' . $extension,
			];
		}

		$image_info = @getimagesize($image['path']);
		if ($image_info === false || !isset($image_info['mime']))
		{
			return ['error' => 'invalid_type'];
		}

		$mime_types = [
			'image/jpeg' => ['extensions' => ['jpg', 'jpeg'], 'target_extension' => '.jpg'],
			'image/jpg' => ['extensions' => ['jpg', 'jpeg'], 'target_extension' => '.jpg'],
			'image/pjpeg' => ['extensions' => ['jpg', 'jpeg'], 'target_extension' => '.jpg'],
			'image/png' => ['extensions' => ['png'], 'target_extension' => '.png'],
			'image/x-png' => ['extensions' => ['png'], 'target_extension' => '.png'],
			'image/gif' => ['extensions' => ['gif'], 'target_extension' => '.gif'],
			'image/giff' => ['extensions' => ['gif'], 'target_extension' => '.gif'],
			'image/webp' => ['extensions' => ['webp'], 'target_extension' => '.webp'],
			'image/avif' => ['extensions' => ['avif'], 'target_extension' => '.avif'],
		];
		$mime_type = strtolower($image_info['mime']);
		if (!isset($mime_types[$mime_type]))
		{
			return ['error' => 'invalid_type', 'mime' => $mime_type];
		}

		if (!in_array($extension, $mime_types[$mime_type]['extensions'], true))
		{
			return ['error' => 'mime_mismatch', 'mime' => $mime_type];
		}

		return [
			'error' => '',
			'image_info' => $image_info,
			'target_extension' => $mime_types[$mime_type]['target_extension'],
		];
	}

	public function copy_image(string $source, string $destination): bool
	{
		$root_path = realpath($this->directory);
		$source_path = realpath($source);
		if ($root_path === false || $source_path === false || strcasecmp(dirname($source_path), $root_path) !== 0)
		{
			return false;
		}
		if (is_link($source) || !is_file($source_path) || file_exists($destination) || is_link($destination))
		{
			return false;
		}

		return @copy($source_path, $destination);
	}

	private function is_valid_schema_id(string $schema_id): bool
	{
		return preg_match('/^[a-f0-9]{32}$/', $schema_id) === 1;
	}

	private function validate_state(array $state): bool
	{
		$required_keys = [
			'creator_id',
			'album_id',
			'start_time',
			'num_offset',
			'done_images',
			'todo_images',
			'image_name',
			'filename',
			'user_data',
			'images',
			'errors',
		];
		$state_keys = array_keys($state);
		sort($required_keys);
		sort($state_keys);
		if ($required_keys !== $state_keys)
		{
			return false;
		}

		if (!is_int($state['creator_id']) || $state['creator_id'] < 1 || !is_int($state['album_id']) || $state['album_id'] < 1 || !is_int($state['start_time']) || $state['start_time'] < 1)
		{
			return false;
		}
		if (!is_int($state['num_offset']) || $state['num_offset'] < 0 || !is_int($state['done_images']) || $state['done_images'] < 0 || !is_int($state['todo_images']) || $state['todo_images'] < 0)
		{
			return false;
		}
		if (!is_bool($state['filename']) || !$this->is_valid_string($state['image_name'], 255) || !is_array($state['user_data']) || !is_array($state['images']) || !is_array($state['errors']))
		{
			return false;
		}

		$user_keys = array_keys($state['user_data']);
		sort($user_keys);
		if ($user_keys !== ['user_colour', 'user_id', 'username'] || !is_int($state['user_data']['user_id']) || $state['user_data']['user_id'] < 1)
		{
			return false;
		}
		if (!$this->is_valid_string($state['user_data']['username'], 255) || !$this->is_valid_string($state['user_data']['user_colour'], 32))
		{
			return false;
		}

		if ($state['images'] !== array_values($state['images']) || count($state['images']) > self::MAX_IMAGES || $state['todo_images'] !== count($state['images']))
		{
			return false;
		}
		foreach ($state['images'] as $image)
		{
			if (!$this->is_valid_string($image, 4096))
			{
				return false;
			}
		}

		if ($state['errors'] !== array_values($state['errors']) || count($state['errors']) > self::MAX_ERRORS)
		{
			return false;
		}
		foreach ($state['errors'] as $error)
		{
			if (!$this->is_valid_string($error, 65535))
			{
				return false;
			}
		}

		return true;
	}

	private function is_valid_string(mixed $value, int $maximum_length): bool
	{
		return is_string($value) && strlen($value) <= $maximum_length && preg_match('//u', $value) === 1 && preg_match('/[\x00-\x1F\x7F]/', $value) !== 1;
	}

	/**
	 * @return string|false
	 */
	private function filename_to_utf8(string $filename): string|false
	{
		if (preg_match('//u', $filename) === 1)
		{
			return $filename;
		}

		$encoding = mb_detect_encoding($filename, ['ISO-8859-1', 'Windows-1252'], true);
		if ($encoding === false)
		{
			return false;
		}

		$converted = mb_convert_encoding($filename, 'UTF-8', $encoding);
		return preg_match('//u', $converted) === 1 ? $converted : false;
	}

	private function get_readable_filename(string $filename): string|false
	{
		$display_name = $this->filename_to_utf8($filename);
		if ($display_name === false || !$this->is_valid_string($display_name, 4096))
		{
			$this->ignored_unreadable_files++;
			return false;
		}

		return $display_name;
	}
}
