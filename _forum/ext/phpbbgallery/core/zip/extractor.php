<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\zip;

/**
 * Validate and extract permitted images from a ZIP archive.
 *
 * Archive paths are never used as destination paths. The complete archive index is
 * validated before a single byte is written, and each accepted entry is then streamed
 * to a name the caller chooses, with its length and CRC checked as it goes.
 *
 * The front-end upload and the ACP import both extract archives, but they disagree on
 * where the files go, what they are called and how many are allowed, so all three are
 * decided by the caller.
 */
final class extractor
{
	/** Maximum number of entries inspected in a ZIP archive. */
	public const MAX_ENTRIES = 1000;

	/** Maximum number of images extracted from a single front-end ZIP upload. */
	public const MAX_IMAGES = 100;

	/** Absolute cap for all uncompressed image data in a ZIP archive (256 MiB). */
	public const MAX_UNCOMPRESSED_SIZE = 268435456;

	/** Space reserved for the central directory and other ZIP metadata (1 MiB). */
	public const MAX_METADATA_SIZE = 1048576;

	/** Maximum accepted ratio between uncompressed and compressed entry sizes. */
	public const MAX_COMPRESSION_RATIO = 100;

	/** Maximum archive path length in bytes. */
	public const MAX_PATH_LENGTH = 4096;

	/** Maximum archive filename length in bytes. */
	public const MAX_FILENAME_LENGTH = 255;

	/** @var \phpbb\language\language */
	private object $language;

	/** @var array Errors collected during the last extraction */
	private array $errors = [];

	/** @var array Extracted files, keyed by their written path */
	private array $files = [];

	/** @var bool Whether the caller's image allowance was reached or exhausted */
	private bool $quota_reached = false;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language $language Language object
	 */
	public function __construct(\phpbb\language\language $language)
	{
		$this->language = $language;
	}

	/**
	 * Derive extraction limits from an image allowance and a per-file size.
	 *
	 * @param int  $remaining_images Images the caller is still willing to accept
	 * @param int  $max_filesize     Largest single image the caller accepts
	 * @param bool $quota_limited    Whether the allowance comes from a quota rather than the cap
	 * @return array
	 */
	public static function limits(int $remaining_images, int $max_filesize, bool $quota_limited = false): array
	{
		$remaining_images = max(0, $remaining_images);

		$entry_size = min(self::MAX_UNCOMPRESSED_SIZE, max(1, (int) ceil(1.2 * $max_filesize)));
		$total_size = min(self::MAX_UNCOMPRESSED_SIZE, $entry_size * max(1, $remaining_images));
		$archive_size = min(self::MAX_UNCOMPRESSED_SIZE, $total_size + self::MAX_METADATA_SIZE);

		return [
			'image_count' => $remaining_images,
			'entry_size' => $entry_size,
			'total_size' => $total_size,
			'archive_size' => $archive_size,
			'quota_limited' => $quota_limited,
		];
	}

	/**
	 * Extract every permitted image from an archive into a directory.
	 *
	 * @param string   $archive_path       Archive to read
	 * @param string   $target_dir         Directory to write into, with a trailing separator
	 * @param array    $allowed_extensions Enabled image extensions
	 * @param array    $limits             Limits from self::limits()
	 * @param callable $name_entry         fn(array $entry, int $index): string|false — the
	 *                                     basename to write the entry to, or false to skip it
	 * @return bool
	 */
	public function extract(string $archive_path, string $target_dir, array $allowed_extensions, array $limits, callable $name_entry): bool
	{
		$this->errors = [];
		$this->files = [];
		$this->quota_reached = false;

		if (!class_exists('ZipArchive'))
		{
			$this->new_error($this->language->lang('ZIP_EXTENSION_NOT_AVAILABLE'));
			return false;
		}

		if ($limits['image_count'] < 1)
		{
			// Nothing may be accepted at all; the caller reports this as a quota problem.
			$this->quota_reached = true;
			return false;
		}

		$archive_size = @filesize($archive_path);
		if ($archive_size === false || $archive_size < 1 || $archive_size > $limits['archive_size'])
		{
			$this->new_error($this->language->lang('ZIP_SIZE_LIMIT_EXCEEDED'));
			return false;
		}

		$zip = new \ZipArchive();
		$open_result = $zip->open($archive_path, \ZipArchive::CHECKCONS);
		if ($open_result !== true)
		{
			$this->new_error($this->language->lang('ZIP_INVALID_ARCHIVE'));
			return false;
		}

		try
		{
			$entries = $this->read_index($zip, $allowed_extensions, $limits);
			if ($entries === false)
			{
				return false;
			}

			foreach ($entries as $index => $entry)
			{
				$name = $name_entry($entry, $index);
				if ($name === false)
				{
					continue;
				}

				if (!$this->extract_entry($zip, $entry, $target_dir . $name, $limits['entry_size']))
				{
					return false;
				}
			}

			return true;
		}
		finally
		{
			$zip->close();
		}
	}

	/**
	 * Validate the whole archive index before anything is written.
	 *
	 * @param \ZipArchive $zip                Open archive
	 * @param array       $allowed_extensions Enabled image extensions
	 * @param array       $limits             Limits from self::limits()
	 * @return array|false Accepted entries, or false when the archive is refused
	 */
	private function read_index(\ZipArchive $zip, array $allowed_extensions, array $limits): array|false
	{
		$entry_count = (int) $zip->numFiles;
		if ($entry_count < 1)
		{
			$this->new_error($this->language->lang('ZIP_NO_IMAGES'));
			return false;
		}

		if ($entry_count > self::MAX_ENTRIES)
		{
			$this->new_error($this->language->lang('ZIP_TOO_MANY_ENTRIES', self::MAX_ENTRIES));
			return false;
		}

		$entries = [];
		$seen_paths = [];
		$total_size = 0;
		$allowed_extensions = array_fill_keys($allowed_extensions, true);

		for ($index = 0; $index < $entry_count; $index++)
		{
			$entry = $zip->statIndex($index);
			if ($entry === false || !isset($entry['name'], $entry['size'], $entry['comp_size'], $entry['crc']))
			{
				$this->new_error($this->language->lang('ZIP_INVALID_ARCHIVE'));
				return false;
			}

			$normalized_path = $this->validate_path($entry['name']);
			if ($normalized_path === false)
			{
				$this->new_error($this->language->lang('ZIP_UNSAFE_PATH'));
				return false;
			}

			$path_key = strtolower($normalized_path);
			if (isset($seen_paths[$path_key]))
			{
				$this->new_error($this->language->lang('ZIP_DUPLICATE_PATH'));
				return false;
			}
			$seen_paths[$path_key] = true;

			if (substr($normalized_path, -1) === '/')
			{
				continue;
			}

			$extension = strtolower(pathinfo($normalized_path, PATHINFO_EXTENSION));
			if (!isset($allowed_extensions[$extension]))
			{
				continue;
			}

			if (count($entries) >= $limits['image_count'])
			{
				if ($limits['quota_limited'])
				{
					$this->quota_reached = true;
					continue;
				}

				$this->new_error($this->language->lang('ZIP_TOO_MANY_IMAGES', $limits['image_count']));
				return false;
			}

			$size = (int) $entry['size'];
			$compressed_size = (int) $entry['comp_size'];
			if ($size < 1 || $compressed_size < 1 || $size > $limits['entry_size'])
			{
				$this->new_error($this->language->lang('ZIP_SIZE_LIMIT_EXCEEDED'));
				return false;
			}

			if (($size / $compressed_size) > self::MAX_COMPRESSION_RATIO)
			{
				$this->new_error($this->language->lang('ZIP_COMPRESSION_RATIO_EXCEEDED'));
				return false;
			}

			$total_size += $size;
			if ($total_size > $limits['total_size'])
			{
				$this->new_error($this->language->lang('ZIP_SIZE_LIMIT_EXCEEDED'));
				return false;
			}

			$entries[] = [
				'name' => $entry['name'],
				'realname' => basename($normalized_path),
				'extension' => $extension,
				'size' => $size,
				'crc' => $entry['crc'],
			];
		}

		if (empty($entries))
		{
			$this->new_error($this->language->lang('ZIP_NO_IMAGES'));
			return false;
		}

		return $entries;
	}

	/**
	 * Extract one archive entry through a bounded stream and verify its type.
	 *
	 * @param \ZipArchive $zip              Open archive
	 * @param array       $entry            Entry from the validated index
	 * @param string      $target_path      Path to write to
	 * @param int         $entry_size_limit Largest accepted entry
	 * @return bool
	 */
	private function extract_entry(\ZipArchive $zip, array $entry, string $target_path, int $entry_size_limit): bool
	{
		$source = $zip->getStream($entry['name']);
		$target = @fopen($target_path, 'xb');
		if ($source === false || $target === false)
		{
			if (is_resource($source))
			{
				fclose($source);
			}
			if (is_resource($target))
			{
				fclose($target);
			}
			@unlink($target_path);
			$this->new_error($this->language->lang('ZIP_EXTRACTION_FAILED'));
			return false;
		}

		$bytes_written = 0;
		$hash = hash_init('crc32b');
		$stream_valid = true;

		while (!feof($source))
		{
			$chunk = fread($source, 8192);
			if ($chunk === false)
			{
				$stream_valid = false;
				break;
			}
			if ($chunk === '')
			{
				if (!feof($source))
				{
					$stream_valid = false;
				}
				break;
			}

			$chunk_size = strlen($chunk);
			$bytes_written += $chunk_size;
			if ($bytes_written > $entry_size_limit || $bytes_written > $entry['size'])
			{
				$stream_valid = false;
				break;
			}

			hash_update($hash, $chunk);
			if (fwrite($target, $chunk) !== $chunk_size)
			{
				$stream_valid = false;
				break;
			}
		}

		fclose($source);
		fclose($target);

		$expected_crc = strtolower(substr(sprintf('%08x', $entry['crc']), -8));
		$actual_crc = strtolower(hash_final($hash));
		if (!$stream_valid || $bytes_written !== $entry['size'] || $actual_crc !== $expected_crc)
		{
			@unlink($target_path);
			$this->new_error($this->language->lang('ZIP_EXTRACTION_FAILED'));
			return false;
		}

		$image_info = @getimagesize($target_path);
		if (!$this->is_allowed_image($image_info, $entry['extension']))
		{
			@unlink($target_path);
			$this->new_error($this->language->lang('ZIP_INVALID_IMAGE_TYPE', $entry['realname']));
			return false;
		}

		$this->files[$target_path] = [
			'type' => $image_info['mime'],
			'size' => $bytes_written,
			'realname' => $entry['realname'],
		];

		return true;
	}

	/**
	 * Validate an archive entry path without using it as a filesystem path.
	 *
	 * @param string $path Path as stored in the archive
	 * @return string|false Normalised path, or false when it is not safe
	 */
	public function validate_path(string $path): string|false
	{
		if ($path === '' || strlen($path) > self::MAX_PATH_LENGTH || preg_match('//u', $path) !== 1 || preg_match('#[\x00-\x1F\x7F]#', $path))
		{
			return false;
		}

		$normalized_path = str_replace('\\', '/', $path);
		if ($normalized_path[0] === '/' || strpos($normalized_path, '//') !== false || preg_match('#^[a-z]:/#i', $normalized_path))
		{
			return false;
		}

		$is_directory = substr($normalized_path, -1) === '/';
		$trimmed_path = ($is_directory) ? substr($normalized_path, 0, -1) : $normalized_path;
		if ($trimmed_path === '')
		{
			return false;
		}

		$segments = explode('/', $trimmed_path);
		foreach ($segments as $segment)
		{
			if ($segment === '' || $segment === '.' || $segment === '..' || strlen($segment) > self::MAX_FILENAME_LENGTH || preg_match('#[<>:\x22|?*]#', $segment) || preg_match('#[. ]$#', $segment))
			{
				return false;
			}

			if (preg_match('#^(con|prn|aux|nul|com[1-9]|lpt[1-9])(?:\.|$)#i', $segment))
			{
				return false;
			}
		}

		return $normalized_path;
	}

	/**
	 * Files written by the last extraction, keyed by path.
	 *
	 * @return array
	 */
	public function get_files(): array
	{
		return $this->files;
	}

	/**
	 * Whether the last extraction hit the caller's image allowance.
	 *
	 * @return bool
	 */
	public function quota_reached(): bool
	{
		return $this->quota_reached;
	}

	/**
	 * Errors collected during the last extraction.
	 *
	 * @return array
	 */
	public function errors(): array
	{
		return $this->errors;
	}

	/**
	 * Verify that the detected image type matches an enabled extension.
	 *
	 * @param array|false $image_info Result of getimagesize()
	 * @param string      $extension  Extension declared by the archive entry
	 * @return bool
	 */
	private function is_allowed_image(array|false $image_info, string $extension): bool
	{
		if ($image_info === false || !isset($image_info[2], $image_info['mime']))
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
	 * @param string $message Error message
	 * @return void
	 */
	private function new_error(string $message): void
	{
		$this->errors[] = $message;
	}
}
