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

/**
 * Unpack a ZIP archive into the import folder.
 *
 * The images are written under readable, deduplicated names so that what lands in
 * the folder is indistinguishable from images uploaded there by hand — which is what
 * lets the ordinary import flow take over without knowing an archive was involved.
 *
 * Nothing is placed in the import folder until the whole archive has extracted
 * cleanly, so a refused or corrupt archive never leaves half its contents behind.
 */
class archive_importer
{
	/** @var \phpbbgallery\acpimport\acp\import_storage */
	private import_storage $storage;

	/** @var \phpbbgallery\core\zip\extractor */
	private object $extractor;

	/** @var \phpbb\language\language */
	private object $language;

	/** @var string Import directory, with a trailing separator */
	private string $directory;

	/** @var array Translated errors from the last extraction */
	private array $errors = [];

	/**
	 * Constructor
	 *
	 * @param \phpbbgallery\acpimport\acp\import_storage $storage   Import storage
	 * @param \phpbbgallery\core\zip\extractor           $extractor Shared ZIP extractor
	 * @param \phpbb\language\language                   $language  Language object
	 * @param string                                     $directory Import directory
	 */
	public function __construct(import_storage $storage, object $extractor, object $language, string $directory)
	{
		$this->storage = $storage;
		$this->extractor = $extractor;
		$this->language = $language;
		$this->directory = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR;
	}

	/**
	 * Extract one archive into the import folder.
	 *
	 * @param array $archive            Archive entry from import_storage::get_archives()
	 * @param array $allowed_extensions Enabled image extensions
	 * @param int   $max_images         Images this archive may yield
	 * @param int   $max_filesize       Largest single image accepted
	 * @return int|false Number of images placed in the import folder, or false
	 */
	public function extract(array $archive, array $allowed_extensions, int $max_images, int $max_filesize): int|false
	{
		$this->errors = [];

		if (!isset($archive['path']) || !is_string($archive['path']) || !is_file($archive['path']))
		{
			$this->errors[] = $this->language->lang('ZIP_INVALID_ARCHIVE');
			return false;
		}

		$temporary_directory = $this->create_temporary_directory();
		if ($temporary_directory === false)
		{
			$this->errors[] = $this->language->lang('ZIP_EXTRACTION_FAILED');
			return false;
		}

		try
		{
			$reserved = [];
			$extracted = $this->extractor->extract(
				$archive['path'],
				$temporary_directory,
				$allowed_extensions,
				\phpbbgallery\core\zip\extractor::limits($max_images, $max_filesize),
				function (array $entry) use (&$reserved): string|false {
					$name = $this->storage->reserve_extracted_name($entry['realname'], $reserved);
					if ($name === false)
					{
						return false;
					}
					$reserved[$name] = true;

					return $name;
				}
			);

			$this->errors = $this->extractor->errors();
			if (!$extracted)
			{
				return false;
			}

			return $this->move_into_import_folder($this->extractor->get_files());
		}
		catch (\Throwable $exception)
		{
			$this->errors[] = $this->language->lang('ZIP_EXTRACTION_FAILED');
			return false;
		}
		finally
		{
			$this->remove_temporary_directory($temporary_directory);
		}
	}

	/**
	 * Translated errors from the last extraction, ready to be shown.
	 *
	 * @return array
	 */
	public function errors(): array
	{
		return $this->errors;
	}

	/**
	 * Move the extracted images up into the import folder.
	 *
	 * @param array $files Files from the extractor, keyed by path
	 * @return int Number of images that arrived
	 */
	private function move_into_import_folder(array $files): int
	{
		$moved = 0;
		foreach (array_keys($files) as $path)
		{
			$name = basename($path);
			$target = $this->directory . $name;
			if (file_exists($target) || is_link($target))
			{
				// The name was reserved against this folder moments ago, so this only
				// happens if something else wrote it in the meantime.
				$this->errors[] = $this->language->lang('ZIP_DUPLICATE_PATH');
				continue;
			}

			if (@rename($path, $target))
			{
				@chmod($target, 0644);
				$moved++;
			}
			else
			{
				$this->errors[] = $this->language->lang('ZIP_EXTRACTION_FAILED');
			}
		}

		return $moved;
	}

	/**
	 * @return string|false Directory with a trailing separator, or false
	 */
	private function create_temporary_directory(): string|false
	{
		$path = $this->directory . 'tmp_' . bin2hex(random_bytes(16)) . DIRECTORY_SEPARATOR;
		if (file_exists($path) || is_link($path) || !@mkdir($path, 0700))
		{
			return false;
		}

		return $path;
	}

	/**
	 * @param string $directory Directory to remove
	 * @return void
	 */
	private function remove_temporary_directory(string $directory): void
	{
		if (is_link($directory))
		{
			@unlink($directory);
			return;
		}

		if (!is_dir($directory))
		{
			return;
		}

		$files = @scandir($directory);
		if ($files !== false)
		{
			foreach (array_diff($files, ['.', '..']) as $name)
			{
				$path = $directory . $name;
				if (is_dir($path) && !is_link($path))
				{
					$this->remove_temporary_directory($path . DIRECTORY_SEPARATOR);
				}
				else
				{
					@unlink($path);
				}
			}
		}

		@rmdir($directory);
	}
}
