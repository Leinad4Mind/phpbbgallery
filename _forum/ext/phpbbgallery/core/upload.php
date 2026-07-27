<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

class upload
{
	/**
	* @var \phpbb\user
	*/
	protected object $user;

	/**
	* @var \phpbb\language\language
	*/
	protected object $language;

	/**
	* @var \phpbb\db\driver\driver_interface
	*/
	protected object $db;

	/**
	* @var \phpbb\event\dispatcher_interface
	*/
	protected \phpbb\event\dispatcher_interface $phpbb_dispatcher;

	/**
	* @var \phpbb\request\request
	*/
	protected \phpbb\request\request $request;

	/**
	* @var \phpbb\files\upload
	*/
	protected object $file_upload;

	/**
	* @var \phpbbgallery\core\image\image
	*/
	protected object $gallery_image;

	/**
	* @var \phpbbgallery\core\config
	*/
	protected object $gallery_config;

	/**
	* @var \phpbbgallery\core\url
	*/
	protected object $gallery_url;

	/**
	* @var \phpbbgallery\core\block
	*/
	protected object $block;

	/**
	* @var \phpbbgallery\core\file\file
	*/
	protected \phpbbgallery\core\file\file $tools;

	/**
	* @var string
	*/
	protected string $images_table;

	/**
	* @var string
	*/
	protected string $root_path;

	/**
	* @var string
	*/
	protected string $php_ext;

	/**
	* Number of Files per Directory
	*
	* If this constant is set to a value >0 the gallery will create a new directory,
	* when the current directory has more files in it than set here.
	*/
	public const NUM_FILES_PER_DIR = 0;

	/** Maximum number of entries inspected in a ZIP archive. */
	private const ZIP_MAX_ENTRIES = 1000;

	/** Maximum number of images extracted from a single ZIP archive. */
	private const ZIP_MAX_IMAGES = 100;

	/** Absolute cap for all uncompressed image data in a ZIP archive (256 MiB). */
	private const ZIP_MAX_UNCOMPRESSED_SIZE = 268435456;

	/** Space reserved for the central directory and other ZIP metadata (1 MiB). */
	private const ZIP_MAX_METADATA_SIZE = 1048576;

	/** Maximum accepted ratio between uncompressed and compressed entry sizes. */
	private const ZIP_MAX_COMPRESSION_RATIO = 100;

	/** Maximum archive path length in bytes. */
	private const ZIP_MAX_PATH_LENGTH = 4096;

	/** Maximum archive filename length in bytes. */
	private const ZIP_MAX_FILENAME_LENGTH = 255;

	/** Keep unfinished upload drafts for seven days. */
	private const ORPHAN_RETENTION_SECONDS = 604800;

	/** Permit a larger source file when it will be resized before storage. */
	private const RESIZE_SOURCE_SIZE_MULTIPLIER = 32;

	/** Absolute source-file cap for resizeable uploads (64 MiB). */
	private const MAX_RESIZE_SOURCE_FILESIZE = 67108864;

	/**
	* Objects: phpBB Upload, 2 Files and Image-Functions
	*/
	/** @var \phpbb\files\filespec|null Current image upload file. */
	private ?object $file = null;

	/** @var \phpbb\files\filespec|null Current ZIP upload file. */
	private ?object $zip_file = null;

	/**
	* Basic variables...
	*/
	public int $loaded_files = 0;
	public int $uploaded_files = 0;
	public array $errors = [];
	public array $images = [];
	public array $image_data = [];
	public array $array_id2row = [];
	public string $error_prefix = '';
	public int $max_filesize = 0;
	private int $source_max_filesize = 0;
	private int $file_limit = 0;
	private int $album_id = 0;
	private int $file_count = 0;
	private int $image_num = 0;
	private bool $allow_comments = false;
	private bool $sent_quota_error = false;
	private string $username = '';
	private int $author_user_id = 0;
	private string $author_username = '';
	private string $author_user_colour = '';
	private array $file_descriptions = [];
	private array $file_names = [];
	private array $file_rotating = [];
	private array $zip_file_data = [];
	private bool $allow_zip = true;

	public int $min_width = 0;
	public int $min_height = 0;
	public int $max_width = 0;
	public int $max_height = 0;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user                       $user           phpBB User class
	 * @param \phpbb\language\language          $language
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\event\dispatcher_interface $phpbb_dispatcher
	 * @param \phpbb\request\request            $request
	 * @param \phpbb\files\upload               $file_upload
	 * @param \phpbbgallery\core\image\image    $gallery_image
	 * @param \phpbbgallery\core\config         $gallery_config Gallery Config
	 * @param \phpbbgallery\core\url            $gallery_url    Gallery url
	 * @param block                             $block
	 * @param file\file                         $gallery_file
	 * @param string                            $images_table
	 * @param string                            $root_path
	 * @param string                            $php_ext
	 */
	public function __construct(\phpbb\user $user, \phpbb\language\language $language, \phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher, \phpbb\request\request $request, \phpbb\files\upload $file_upload,
		\phpbbgallery\core\image\image $gallery_image, \phpbbgallery\core\config $gallery_config, \phpbbgallery\core\url $gallery_url,
		\phpbbgallery\core\block $block, \phpbbgallery\core\file\file $gallery_file,
		string $images_table, string $root_path, string $php_ext)
	{
		$this->user = $user;
		$this->language = $language;
		$this->db = $db;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->request = $request;
		$this->file_upload = $file_upload;
		$this->gallery_image = $gallery_image;
		$this->gallery_config = $gallery_config;
		$this->gallery_url	= $gallery_url;
		$this->block = $block;
		$this->tools = $gallery_file;
		$this->images_table = $images_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * As we have to use construct for setting up infrastructure the right way,
	 * we'll be creating this setup function that should setup everything.
	 * @param int  $album_id  Album ID we are uploading to
	 * @param int  $num_files Number of files we upload
	 * @param bool $allow_zip Whether this upload operation accepts ZIP archives
	 */
	public function set_up(int $album_id, int $num_files = 0, bool $allow_zip = true): void
	{
		$this->allow_zip = $allow_zip;
		$this->file_upload->set_allowed_extensions($this->get_allowed_types(false, !$allow_zip));

		$this->album_id = (int) $album_id;
		$this->file_limit = (int) $num_files;
		$this->username = $this->user->data['username'];
		$this->author_user_id = 0;
		$this->author_username = '';
		$this->author_user_colour = '';

		$this->max_filesize = max(1, (int) $this->gallery_config->get('max_filesize'));
		$this->source_max_filesize = $this->calculate_source_filesize_limit(
			$this->max_filesize,
			(bool) $this->gallery_config->get('allow_resize')
		);
		$this->file_upload->set_max_filesize($this->source_max_filesize);
	}

	/**
	 * Return the largest source file accepted by the upload handler.
	 */
	public function get_source_filesize_limit(): int
	{
		return $this->source_max_filesize ?: $this->max_filesize;
	}

	/**
	 * Calculate a bounded source limit while keeping the configured limit as the
	 * final stored-file limit.
	 */
	private function calculate_source_filesize_limit(int $final_filesize, bool $allow_resize): int
	{
		$final_filesize = max(1, $final_filesize);
		if (!$allow_resize)
		{
			return $final_filesize;
		}

		$scaled_filesize = $final_filesize > intdiv(PHP_INT_MAX, self::RESIZE_SOURCE_SIZE_MULTIPLIER)
			? PHP_INT_MAX
			: $final_filesize * self::RESIZE_SOURCE_SIZE_MULTIPLIER;

		return max($final_filesize, min(self::MAX_RESIZE_SOURCE_FILESIZE, $scaled_filesize));
	}

	/**
	 * Upload a file and then call the function for reading the zip or preparing the image
	 *
	 * @param int $file_count
	 * @return bool
	 */
	public function upload_file(int $file_count): bool
	{
		if ($this->file_limit && ($this->uploaded_files >= $this->file_limit))
		{
			$this->quota_error();
			return false;
		}
		$this->file_count = (int) $file_count;

		$files = $this->file_upload->handle_upload('phpbbgallery.core.files.types.multiform', 'files');

		foreach ($files as $var)
		{
			$this->file = $var;
			if (!$this->file->get('uploadname'))
			{
				return false;
			}

			if ($this->file->get('extension') == 'zip')
			{
				$this->zip_file = $this->file;
				$this->upload_zip();
			}
			else
			{
				$image_id = $this->prepare_file();
				if ($image_id)
				{
					$this->uploaded_files++;
					$this->images[] = (int) $image_id;
				}
			}
		}

		return true;
	}

	/**
	* Upload a zip file and save the images into the import/ directory.
	*/
	public function upload_zip(): bool
	{
		$this->language->add_lang('gallery_zip', 'phpbbgallery/core');

		$tmp_dir = $this->create_zip_temp_directory_path();

		$this->zip_file->clean_filename('unique_ext');
		$this->zip_file->move_file(
			substr($this->gallery_url->path('import_noroot'), 0, -1),
			false,
			false,
			\phpbb\filesystem\filesystem_interface::CHMOD_READ | \phpbb\filesystem\filesystem_interface::CHMOD_WRITE
		);
		if (!empty($this->zip_file->error))
		{
			$this->zip_file->remove();
			$this->new_error($this->language->lang('UPLOAD_ERROR', $this->zip_file->get('uploadname'), implode('<br />&raquo; ', $this->zip_file->error)));
			return false;
		}

		// Remove zip from allowed extensions
		$this->file_upload->set_allowed_extensions($this->get_allowed_types(false, true));
		$tmp_dir_created = false;

		try
		{
			if (file_exists($tmp_dir) || is_link($tmp_dir) || !@mkdir($tmp_dir, 0700))
			{
				$this->new_error($this->language->lang('ZIP_EXTRACTION_FAILED'));
				return false;
			}
			$tmp_dir_created = true;

			if (!$this->extract_zip($this->zip_file->get('destination_file'), $tmp_dir))
			{
				return false;
			}

			$this->read_zip_folder($tmp_dir);
			return true;
		}
		catch (\Throwable $exception)
		{
			$this->new_error($this->language->lang('ZIP_EXTRACTION_FAILED'));
			return false;
		}
		finally
		{
			try
			{
				$this->zip_file->remove();
			}
			finally
			{
				if ($tmp_dir_created)
				{
					$this->remove_zip_temp_dir($tmp_dir);
				}
				$this->zip_file_data = [];

				// Read zip from allowed extensions
				$this->file_upload->set_allowed_extensions($this->get_allowed_types());
			}
		}
	}

	/**
	 * Generate an unpredictable extraction directory for a ZIP upload.
	 *
	 * @return string Absolute temporary directory path
	 */
	protected function create_zip_temp_directory_path(): string
	{
		return $this->gallery_url->path('import') . 'tmp_' . bin2hex(random_bytes(16)) . '/';
	}

	/**
	 * Validate and extract permitted images from a ZIP archive.
	 *
	 * Archive paths are never used as destination paths. Each accepted entry is
	 * streamed to a generated filename after the complete archive index passes
	 * validation.
	 *
	 * @param string $archive_path
	 * @param string $target_dir
	 * @return bool
	 */
	private function extract_zip(string $archive_path, string $target_dir): bool
	{
		if (!class_exists('ZipArchive'))
		{
			$this->new_error($this->language->lang('ZIP_EXTENSION_NOT_AVAILABLE'));
			return false;
		}

		$limits = $this->get_zip_limits();
		if ($limits['image_count'] < 1)
		{
			$this->quota_error();
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
			$entry_count = (int) $zip->numFiles;
			if ($entry_count < 1)
			{
				$this->new_error($this->language->lang('ZIP_NO_IMAGES'));
				return false;
			}

			if ($entry_count > self::ZIP_MAX_ENTRIES)
			{
				$this->new_error($this->language->lang('ZIP_TOO_MANY_ENTRIES', self::ZIP_MAX_ENTRIES));
				return false;
			}

			$entries = [];
			$seen_paths = [];
			$total_size = 0;
			$quota_reached = false;
			$allowed_extensions = array_fill_keys($this->get_allowed_types(false, true), true);

			for ($index = 0; $index < $entry_count; $index++)
			{
				$entry = $zip->statIndex($index);
				if ($entry === false || !isset($entry['name'], $entry['size'], $entry['comp_size'], $entry['crc']))
				{
					$this->new_error($this->language->lang('ZIP_INVALID_ARCHIVE'));
					return false;
				}

				$normalized_path = $this->validate_zip_path($entry['name']);
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
						$quota_reached = true;
						continue;
					}

					$this->new_error($this->language->lang('ZIP_TOO_MANY_IMAGES', self::ZIP_MAX_IMAGES));
					return false;
				}

				$size = (int) $entry['size'];
				$compressed_size = (int) $entry['comp_size'];
				if ($size < 1 || $compressed_size < 1 || $size > $limits['entry_size'])
				{
					$this->new_error($this->language->lang('ZIP_SIZE_LIMIT_EXCEEDED'));
					return false;
				}

				if (($size / $compressed_size) > self::ZIP_MAX_COMPRESSION_RATIO)
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

			foreach ($entries as $index => $entry)
			{
				$target_path = $target_dir . 'image_' . $index . '.' . $entry['extension'];
				if (!$this->extract_zip_entry($zip, $entry, $target_path, $limits['entry_size']))
				{
					return false;
				}
			}

			if ($quota_reached)
			{
				$this->quota_error();
			}

			return true;
		}
		finally
		{
			$zip->close();
		}
	}

	/**
	 * Extract one archive entry through a bounded stream and verify its type.
	 *
	 * @param \ZipArchive $zip
	 * @param array       $entry
	 * @param string      $target_path
	 * @param int         $entry_size_limit
	 * @return bool
	 */
	private function extract_zip_entry(\ZipArchive $zip, array $entry, string $target_path, int $entry_size_limit): bool
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
		if (!$this->is_allowed_zip_image($image_info, $entry['extension']))
		{
			@unlink($target_path);
			$this->new_error($this->language->lang('ZIP_INVALID_IMAGE_TYPE', $entry['realname']));
			return false;
		}

		$this->zip_file_data[$target_path] = [
			'type' => $image_info['mime'],
			'size' => $bytes_written,
			'realname' => $entry['realname'],
		];

		return true;
	}

	/**
	 * Return extraction limits derived from the gallery quota and file size.
	 *
	 * @return array
	 */
	private function get_zip_limits(): array
	{
		$remaining_images = self::ZIP_MAX_IMAGES;
		$quota_limited = false;
		if ($this->file_limit)
		{
			$remaining_images = max(0, $this->file_limit - $this->uploaded_files);
			$quota_limited = $remaining_images <= self::ZIP_MAX_IMAGES;
		}
		$remaining_images = min($remaining_images, self::ZIP_MAX_IMAGES);

		$source_filesize = $this->source_max_filesize ?: $this->max_filesize;
		$entry_size = min(self::ZIP_MAX_UNCOMPRESSED_SIZE, max(1, (int) ceil(1.2 * $source_filesize)));
		$total_size = min(self::ZIP_MAX_UNCOMPRESSED_SIZE, $entry_size * max(1, $remaining_images));
		$archive_size = min(self::ZIP_MAX_UNCOMPRESSED_SIZE, $total_size + self::ZIP_MAX_METADATA_SIZE);

		return [
			'image_count' => $remaining_images,
			'entry_size' => $entry_size,
			'total_size' => $total_size,
			'archive_size' => $archive_size,
			'quota_limited' => $quota_limited,
		];
	}

	/**
	 * Validate an archive entry path without using it as a filesystem path.
	 *
	 * @param string $path
	 * @return string|false
	 */
	private function validate_zip_path(string $path): string|false
	{
		if ($path === '' || strlen($path) > self::ZIP_MAX_PATH_LENGTH || preg_match('//u', $path) !== 1 || preg_match('#[\x00-\x1F\x7F]#', $path))
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
			if ($segment === '' || $segment === '.' || $segment === '..' || strlen($segment) > self::ZIP_MAX_FILENAME_LENGTH || preg_match('#[<>:\x22|?*]#', $segment) || preg_match('#[. ]$#', $segment))
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
	 * Verify that the detected image type matches an enabled extension.
	 *
	 * @param array|false $image_info
	 * @param string      $extension
	 * @return bool
	 */
	private function is_allowed_zip_image(array|false $image_info, string $extension): bool
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
		];

		return isset($image_types[$image_info[2]]) && in_array($extension, $image_types[$image_info[2]], true);
	}

	/**
	 * Recursively remove a generated ZIP extraction directory.
	 *
	 * @param string $directory
	 * @return void
	 */
	private function remove_zip_temp_dir(string $directory): void
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
		if ($files === false)
		{
			return;
		}

		foreach ($files as $file)
		{
			if ($file === '.' || $file === '..')
			{
				continue;
			}

			$path = $directory . $file;
			if (is_dir($path) && !is_link($path))
			{
				$this->remove_zip_temp_dir($path . '/');
			}
			else
			{
				@unlink($path);
			}
		}

		@rmdir($directory);
	}

	/**
	 * Read a folder from the zip, "upload" the images and remove the rest.
	 *
	 * @param string $current_dir
	 * @return void
	 */
	public function read_zip_folder(string $current_dir): void
	{
		$handle = @opendir($current_dir);
		if ($handle === false)
		{
			$this->new_error($this->language->lang('ZIP_EXTRACTION_FAILED'));
			return;
		}

		while (($file = readdir($handle)) !== false)
		{
			if ($file === '.' || $file === '..')
			{
				continue;
			}
			if (is_dir($current_dir . $file))
			{
				$this->read_zip_folder($current_dir . $file . '/');
			}
			else if (in_array(utf8_substr(strtolower($file), utf8_strrpos($file, '.') + 1), $this->get_allowed_types(false, true), true))
			{
				if (!$this->file_limit || ($this->uploaded_files < $this->file_limit))
				{
					$path = $current_dir . $file;
					$file_info = (isset($this->zip_file_data[$path])) ? $this->zip_file_data[$path] : [
						'type' => $this->tools->mimetype_by_filename($file),
						'size' => (int) filesize($path),
						'realname' => $file,
					];
					$this->file = $this->file_upload->handle_upload('files.types.local', $path, $file_info);
					if ($this->file->error)
					{
						$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), implode('<br />&raquo; ', $this->file->error)));
					}
					$image_id = $this->prepare_file();

					if ($image_id)
					{
						$this->uploaded_files++;
						$this->images[] = (int) $image_id;
					}
					else
					{
						if ($this->file->error)
						{
							$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), implode('<br />&raquo; ', $this->file->error)));
						}
					}
				}
				else
				{
					$this->quota_error();
					@unlink($current_dir . $file);
				}

			}
			else
			{
				@unlink($current_dir . $file);
			}
		}
		closedir($handle);
		@rmdir($current_dir);
	}

	/**
	 * Update image information in the database: name, description, status, contest, ...
	 *
	 * @param int $image_id
	 * @param bool $needs_approval
	 * @param bool $is_in_contest
	 * @return bool
	 */
	public function update_image(int $image_id, bool $needs_approval = false, bool $is_in_contest = false): bool
	{
		if ($this->file_limit && ($this->uploaded_files > $this->file_limit))
		{
			$this->new_error($this->language->lang('UPLOAD_ERROR', $this->image_data[$image_id]['image_name'], $this->language->lang('QUOTA_REACHED')));
			return false;
		}
		$this->file_count = (int) $this->array_id2row[$image_id];

		// Create message parser instance
		if (!class_exists('parse_message'))
		{
			include_once($this->root_path . 'includes/message_parser.' . $this->php_ext);
		}
		$message_parser = new \parse_message();
		$message_parser->message	= utf8_normalize_nfc($this->get_description());
		if ($message_parser->message)
		{
			$message_parser->parse(true, true, true, true, false, true, true, true);
		}

		$sql_ary = [
			'image_status'				=> ($needs_approval) ? $this->block->get_image_status_unapproved() : $this->block->get_image_status_approved(),
			'image_contest'				=> ($is_in_contest) ? $this->block->get_in_contest() : $this->block->get_no_contest(),
			'image_upload_session_hash'	=> '',
			'image_desc'				=> $message_parser->message,
			'image_desc_uid'			=> $message_parser->bbcode_uid,
			'image_desc_bitfield'		=> $message_parser->bbcode_bitfield,
			'image_time'				=> time() + $this->file_count,
		];
		$new_image_name = $this->get_name();
		if (($new_image_name != '') && ($new_image_name != $this->image_data[$image_id]['image_name']))
		{
			$sql_ary = array_merge($sql_ary, [
				'image_name'		=> $new_image_name,
				'image_name_clean'	=> utf8_clean_string($new_image_name),
			]);
		}
		if ($this->author_user_id > 0)
		{
			$sql_ary = array_merge($sql_ary, [
				'image_user_id'        => $this->author_user_id,
				'image_username'       => $this->author_username,
				'image_username_clean' => utf8_clean_string($this->author_username),
				'image_user_colour'    => $this->author_user_colour,
			]);
		}

		$additional_sql_data = [];
		$image_data = $this->image_data[$image_id];
		$file_link = $this->gallery_url->path('upload') . $this->image_data[$image_id]['image_filename'];

		/**
		* Event upload image before
		*
		* @event phpbbgallery.core.upload.update_image_before
		* @var	array	additional_sql_data		array of additional settings
		* @var	array	image_data				array of image_data
		* @var	string	file_link				link to file
		* @since 1.2.0
		*/
		$vars = ['additional_sql_data', 'image_data', 'file_link'];
		extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.upload.update_image_before', compact($vars)));

		// Rotate image
		if (!$this->prepare_file_update($image_id))
		{
			/**
			* Event upload image update
			*
			* @event phpbbgallery.core.upload.update_image_nofilechange
			* @var	array	additional_sql_data		array of additional settings
			* @since 1.2.0
			*/
			$vars = ['additional_sql_data'];
			extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.upload.update_image_nofilechange', compact($vars)));
		}

		$sql_ary = array_merge($sql_ary, $additional_sql_data);

		$sql = 'UPDATE ' . $this->images_table. ' 
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE image_id = ' . (int) $image_id;
		$this->db->sql_query($sql);
		$this->image_data[$image_id] = array_merge($this->image_data[$image_id], $sql_ary);

		$image_index = $this->file_count;
		$image_data = $this->image_data[$image_id];
		/**
		 * Notify add-ons after an uploaded image has been finalized successfully.
		 *
		 * @event phpbbgallery.core.upload.update_image_after
		 * @var int   image_id    Finalized image identifier
		 * @var int   image_index Zero-based position in the submitted upload batch
		 * @var array image_data  Updated image database row
		 * @var array sql_ary     Values persisted by this finalization
		 * @since 3.4.0
		 */
		$vars = ['image_id', 'image_index', 'image_data', 'sql_ary'];
		extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.upload.update_image_after', compact($vars)));

		return true;
	}

	/**
	* Prepare file on upload: rotate and resize
	*/
	public function prepare_file(): int|false
	{
		$upload_dir = $this->get_current_upload_dir();

		// Rename the file, move it to the correct location and set chmod
		if (!$upload_dir)
		{
			$this->file->clean_filename('unique_ext');
			$this->file->move_file(substr($this->gallery_url->path('upload'), 0, -1), false, false, CHMOD_ALL);
		}
		else
		{
			// Okay, this looks hacky, but what we do here is, we store the directory name in the filename.
			// However phpBB strips directories form the filename, when moving, so we need to specify that again.
			$this->file->clean_filename('unique_ext', $upload_dir . '/');
			$this->file->move_file($this->gallery_url->path('upload_noroot') . $upload_dir, false, false, CHMOD_ALL);
		}

		if (!empty($this->file->error))
		{
			$this->file->remove();
			$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), implode('<br />&raquo; ', $this->file->error)));
			return false;
		}
		@chmod($this->file->get('destination_file'), 0644);
		$additional_sql_data = [];
		$file = $this->file;

		/**
		* Event upload image update
		*
		* @event phpbbgallery.core.upload.prepare_file_before
		* @var	array	additional_sql_data		array of additional settings
		* @var	array	file					File object
		* @since 1.2.0
		*/
		$vars = ['additional_sql_data', 'file'];
		extract($this->phpbb_dispatcher->trigger_event('phpbbgallery.core.upload.prepare_file_before', compact($vars)));

		$source_filesize = (int) $this->file->get('filesize');
		$allow_resize = (bool) $this->gallery_config->get('allow_resize');
		$source_limit = $this->source_max_filesize ?: $this->calculate_source_filesize_limit($this->max_filesize, $allow_resize);
		if ($source_filesize > $source_limit || (!$allow_resize && $source_filesize > $this->max_filesize))
		{
			$this->file->remove();
			$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), $this->language->lang('BAD_UPLOAD_FILE_SIZE')));
			return false;
		}

		$this->tools->set_image_options($this->max_filesize, $this->gallery_config->get('max_height'), $this->gallery_config->get('max_width'));
		$this->tools->set_image_data($this->file->get('destination_file'), '', $source_filesize, true);

		// Reject decompression-bomb uploads (huge declared pixel dimensions in a small file)
		// before any rotate/resize attempt tries to decode the full image into memory.
		if (($this->file->get('width') * $this->file->get('height')) > \phpbbgallery\core\file\file::MAX_DECODE_PIXELS)
		{
			$this->file->remove();
			$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), $this->language->lang('UPLOAD_IMAGE_SIZE_TOO_BIG')));
			return false;
		}

		// Rotate the image
		if ($this->gallery_config->get('allow_rotate') && $this->get_rotating())
		{
			$this->tools->rotate_image($this->get_rotating(), $this->gallery_config->get('allow_resize'));
			if ($this->tools->rotated)
			{
				$this->file->height = $this->tools->image_size['height'];
				$this->file->width = $this->tools->image_size['width'];
			}
		}

		// Resize oversized images
		if (($this->file->get('width') > $this->gallery_config->get('max_width')) || ($this->file->get('height') > $this->gallery_config->get('max_height')))
		{
			if ($allow_resize)
			{
				$this->tools->resize_image($this->gallery_config->get('max_width'), $this->gallery_config->get('max_height'));
				if (!$this->tools->resized)
				{
					$this->file->remove();
					$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), $this->language->lang('UPLOAD_IMAGE_SIZE_TOO_BIG')));
					return false;
				}
			}
			else
			{
				$this->file->remove();
				$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), $this->language->lang('UPLOAD_IMAGE_SIZE_TOO_BIG')));
				return false;
			}
		}

		if ($this->tools->rotated || $this->tools->resized || $source_filesize > $this->max_filesize)
		{
			$stored_filesize = $this->tools->write_image_with_filesize_limit(
				$this->file->get('destination_file'),
				$this->max_filesize,
				$this->gallery_config->get('jpg_quality'),
				$allow_resize
			);
			if ($stored_filesize === false)
			{
				$this->file->remove();
				$this->new_error($this->language->lang('UPLOAD_ERROR', $this->file->get('uploadname'), $this->language->lang('BAD_UPLOAD_FILE_SIZE')));
				return false;
			}
		}

		// Everything okay, now add the file to the database and return the image_id

		return $this->file_to_database($additional_sql_data);
	}

	/**
	 * Prepare file on second upload step.
	 * You can still rotate the image there.
	 *
	 * @param int $image_id
	 * @return bool
	 */
	public function prepare_file_update(int $image_id): bool
	{
		$this->tools->set_image_options($this->max_filesize, $this->gallery_config->get('max_height'), $this->gallery_config->get('max_width'));
		$this->tools->set_image_data($this->gallery_url->path('upload') . $this->image_data[$image_id]['image_filename'], '', 0, true);

		// Rotate the image
		if ($this->gallery_config->get('allow_rotate') && $this->get_rotating())
		{
			$this->tools->rotate_image($this->get_rotating(),$this->gallery_config->get('allow_resize'));
			if ($this->tools->rotated)
			{
				$this->tools->write_image($this->tools->image_source, $this->gallery_config->get('jpg_quality'), true);
				@unlink($this->gallery_url->path('thumbnail') . $this->image_data[$image_id]['image_filename']);
				@unlink($this->gallery_url->path('medium') . $this->image_data[$image_id]['image_filename']);
			}
		}
		return (bool) $this->tools->rotated;
	}

	/**
	 * Insert the file into the database
	 *
	 * @param array $additional_sql_ary
	 * @return int
	 */
	public function file_to_database(array $additional_sql_ary): int
	{
		$image_name = utf8_substr($this->file->get('uploadname'), 0, utf8_strrpos($this->file->get('uploadname'), '.'));
		$stored_filesize = @filesize($this->file->get('destination_file'));

		$sql_ary = array_merge([
			'image_name'			=> $image_name,
			'image_name_clean'		=> utf8_clean_string($image_name),
			'image_filename' 		=> $this->file->get('realname'),
			'filesize_upload'		=> $stored_filesize === false ? $this->file->get('filesize') : (int) $stored_filesize,
			'image_time'			=> time() + $this->file_count,

			'image_user_id'			=> $this->user->data['user_id'],
			'image_user_colour'		=> $this->user->data['user_colour'],
			'image_username'		=> $this->username,
			'image_username_clean'	=> utf8_clean_string($this->username),
			'image_user_ip'			=> $this->user->ip,
			'image_upload_session_hash'	=> $this->get_session_hash(),

			'image_album_id'		=> $this->album_id,
			'image_status'			=> $this->block->get_image_status_orphan(),
			'image_contest'			=> $this->block->get_no_contest(),
			'image_allow_comments'	=> $this->allow_comments,
			'image_desc'			=> '',
			'image_desc_uid'		=> '',
			'image_desc_bitfield'	=> '',
		], $additional_sql_ary);

		$sql = 'INSERT INTO ' . $this->images_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
		$this->db->sql_query($sql);

		$image_id = (int) $this->db->sql_nextid();
		$this->image_data[$image_id] = $sql_ary;

		return $image_id;
	}

	/**
	 * Delete unfinished upload drafts which are older than seven days.
	 *
	 * @param int $time
	 */
	public function prune_orphan(int $time = 0): void
	{
		$prunetime = (int) (($time) ? $time : (time() - self::ORPHAN_RETENTION_SECONDS));

		$sql = 'SELECT image_id, image_filename
			FROM ' . $this->images_table . '
			WHERE image_status = ' . (int) $this->block->get_image_status_orphan() . '
				AND image_time < ' . (int) $prunetime;
		$result = $this->db->sql_query($sql);
		$images = $filenames = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$images[] = (int) $row['image_id'];
			$filenames[(int) $row['image_id']] = $row['image_filename'];
		}
		$this->db->sql_freeresult($result);

		if ($images)
		{
			$this->gallery_image->delete_images($images, $filenames, false);
		}
	}

	/**
	 * Get the current upload dir (doh!)
	 * @return int|string
	 */
	private function get_current_upload_dir(): int|string
	{
		if (self::NUM_FILES_PER_DIR <= 0)
		{
			return 0;
		}

		// This code is never invoked. It's left here for future implementation.
		$this->gallery_config->inc('current_upload_dir_size', 1);
		if ($this->gallery_config->get('current_upload_dir_size') >= self::NUM_FILES_PER_DIR)
		{
			$this->gallery_config->set('current_upload_dir_size', 0);
			$this->gallery_config->inc('current_upload_dir', 1);
			@mkdir($this->gallery_url->path('upload') . $this->gallery_config->get('current_upload_dir'));
			@mkdir($this->gallery_url->path('medium') . $this->gallery_config->get('current_upload_dir'));
			@mkdir($this->gallery_url->path('thumbnail') . $this->gallery_config->get('current_upload_dir'));
			@copy($this->gallery_url->path('upload') . 'index.htm', $this->gallery_url->path('upload') . $this->gallery_config->get('current_upload_dir') . '/index.htm');
			@copy($this->gallery_url->path('upload') . 'index.htm', $this->gallery_url->path('medium') . $this->gallery_config->get('current_upload_dir') . '/index.htm');
			@copy($this->gallery_url->path('upload') . 'index.htm', $this->gallery_url->path('thumbnail') . $this->gallery_config->get('current_upload_dir') . '/index.htm');
			@copy($this->gallery_url->path('upload') . '.htaccess', $this->gallery_url->path('upload') . $this->gallery_config->get('current_upload_dir') . '/.htaccess');
			@copy($this->gallery_url->path('upload') . '.htaccess', $this->gallery_url->path('medium') . $this->gallery_config->get('current_upload_dir') . '/.htaccess');
			@copy($this->gallery_url->path('upload') . '.htaccess', $this->gallery_url->path('thumbnail') . $this->gallery_config->get('current_upload_dir') . '/.htaccess');
		}
		$current_upload_dir = $this->gallery_config->get('current_upload_dir');
		return is_int($current_upload_dir) ? $current_upload_dir : (string) $current_upload_dir;
	}

	public function quota_error(): void
	{
		if ($this->sent_quota_error)
		{
			return;
		}
		$this->new_error($this->language->lang('USER_REACHED_QUOTA_SHORT', $this->file_limit));
		$this->sent_quota_error = true;
	}

	public function new_error(string $error_msg): void
	{
		$this->errors[] = $error_msg;
	}

	public function set_file_limit(int $num_files): void
	{
		$this->file_limit = (int) $num_files;
	}

	public function set_username(string $username): void
	{
		$this->username = $username;
	}

	/**
	 * Apply a trusted registered-user identity when pending images are finalized.
	 */
	public function set_author(int $user_id, string $username, string $user_colour): void
	{
		if ($user_id <= 0 || $username === '')
		{
			$this->author_user_id = 0;
			$this->author_username = '';
			$this->author_user_colour = '';
			return;
		}

		$this->author_user_id = $user_id;
		$this->author_username = $username;
		$this->author_user_colour = $user_colour;
	}

	public function set_rotating(array $data): void
	{
		$this->file_rotating = array_map('intval', $data);
	}

	public function set_allow_comments(bool $value): void
	{
		$this->allow_comments = $value;
	}

	public function set_descriptions(array $descs): void
	{
		$this->file_descriptions = $descs;
	}

	public function set_names(array $names): void
	{
		$this->file_names = $names;
	}

	public function set_image_num(int $num): void
	{
		$this->image_num = (int) $num;
	}

	public function use_same_name(bool $use_same_name): void
	{
		if ($use_same_name && isset($this->file_names[0]))
		{
			$image_name = $this->file_names[0];
			$image_desc = $this->file_descriptions[0] ?? '';
			for ($i = 0; $i < sizeof($this->file_names); $i++)
			{
				$this->file_names[$i] = str_replace('{NUM}', ($this->image_num + $i), $image_name);
				$this->file_descriptions[$i] = str_replace('{NUM}', ($this->image_num + $i), $image_desc);
			}
		}
	}

	public function get_rotating(): int
	{
		if (!isset($this->file_rotating[$this->file_count]))
		{
			// If the template is still outdated, you'd get an error here...
			return 0;
		}
		if (($this->file_rotating[$this->file_count] % 90) != 0)
		{
			return 0;
		}
		return $this->file_rotating[$this->file_count];
	}

	public function get_name(): string
	{
		if (!isset($this->file_names[$this->file_count]))
		{
			return '';
		}

		return utf8_normalize_nfc($this->file_names[$this->file_count]);
	}

	public function get_description(): string
	{
		if (!isset($this->file_descriptions[$this->file_count]))
		{
			// If the template is still outdated, you'd get a general error later...
			return '';
		}
		return utf8_normalize_nfc($this->file_descriptions[$this->file_count]);
	}

	public function get_images(array $uploaded_ids): void
	{
		$image_ids = $filenames = [];
		foreach ($uploaded_ids as $row => $check)
		{
			if (!is_string($check) || strpos($check, '$') === false)
			{
				continue;
			}
			list($image_id, $filename) = explode('$', $check, 2);
			if (!ctype_digit($image_id) || (int) $image_id <= 0 || $filename === '')
			{
				continue;
			}

			$image_id = (int) $image_id;
			if (isset($filenames[$image_id]))
			{
				continue;
			}

			$image_ids[] = $image_id;
			$filenames[$image_id] = $filename;
			$this->array_id2row[$image_id] = $row;
		}

		if (empty($image_ids))
		{
			return;
		}

		$sql = 'SELECT *
			FROM ' . $this->images_table . '
			WHERE ' . $this->get_pending_images_sql() . '
				AND ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_id = (int) $row['image_id'];
			if (isset($filenames[$image_id]) && hash_equals((string) $row['image_filename'], $filenames[$image_id]))
			{
				$this->images[] = $image_id;
				$this->image_data[$image_id] = $row;
				$this->loaded_files++;
			}
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * Load the unfinished upload draft for the current user and album.
	 *
	 * @return int Number of pending images loaded
	 */
	public function load_pending_images(): int
	{
		$this->images = [];
		$this->image_data = [];
		$this->array_id2row = [];
		$this->loaded_files = 0;

		$sql = 'SELECT *
			FROM ' . $this->images_table . '
			WHERE ' . $this->get_pending_images_sql() . '
			ORDER BY image_time ASC, image_id ASC';
		$result = $this->db->sql_query($sql);
		$row_number = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_id = (int) $row['image_id'];
			$this->images[] = $image_id;
			$this->image_data[$image_id] = $row;
			$this->array_id2row[$image_id] = $row_number++;
			$this->loaded_files++;
		}
		$this->db->sql_freeresult($result);

		return $this->loaded_files;
	}

	/**
	 * Delete the unfinished upload draft for the current user and album.
	 *
	 * @return int Number of pending images deleted
	 */
	public function discard_pending_images(): int
	{
		$this->load_pending_images();
		if (!$this->images)
		{
			return 0;
		}

		$image_ids = $this->images;
		$filenames = [];
		foreach ($image_ids as $image_id)
		{
			$filenames[$image_id] = $this->image_data[$image_id]['image_filename'];
		}

		$this->gallery_image->delete_images($image_ids, $filenames, false);
		$this->images = [];
		$this->image_data = [];
		$this->array_id2row = [];
		$this->loaded_files = 0;

		return count($image_ids);
	}

	/**
	 * Delete only the files created by this upload service invocation.
	 *
	 * This is intended for add-ons that use the secure upload pipeline as an
	 * intermediate step and must roll back their own failed operation without
	 * deleting other resumable drafts owned by the same member.
	 *
	 * @return int Number of uploaded images deleted
	 */
	public function discard_uploaded_images(): int
	{
		if (!$this->images)
		{
			return 0;
		}

		$image_ids = $this->images;
		$filenames = [];
		foreach ($image_ids as $image_id)
		{
			if (isset($this->image_data[$image_id]['image_filename']))
			{
				$filenames[$image_id] = $this->image_data[$image_id]['image_filename'];
			}
		}

		$this->gallery_image->delete_images($image_ids, $filenames, false);
		$this->images = [];
		$this->image_data = [];
		$this->array_id2row = [];
		$this->loaded_files = 0;
		$this->uploaded_files = 0;

		return count($image_ids);
	}

	/**
	 * Build the ownership conditions shared by draft loading and finalization.
	 *
	 * @return string
	 */
	private function get_pending_images_sql(): string
	{
		$sql = 'image_status = ' . (int) $this->block->get_image_status_orphan() . '
				AND image_user_id = ' . (int) $this->user->data['user_id'] . '
				AND image_album_id = ' . (int) $this->album_id;

		if (empty($this->user->data['is_registered']))
		{
			$session_hash = $this->get_session_hash();
			if ($session_hash === '')
			{
				return $sql . '
				AND 1 = 0';
			}

			$sql .= "
				AND image_upload_session_hash = '" . $this->db->sql_escape($session_hash) . "'";
		}

		return $sql;
	}

	/**
	 * Get a one-way fingerprint of the current phpBB session.
	 *
	 * @return string
	 */
	private function get_session_hash(): string
	{
		if (isset($this->user->session_id))
		{
			$session_id = (string) $this->user->session_id;
		}
		else
		{
			$session_id = isset($this->user->data['session_id']) ? (string) $this->user->data['session_id'] : '';
		}

		if ($session_id === '')
		{
			return '';
		}

		return hash('sha256', $session_id);
	}

	/**
	 * Get an array of allowed file types or file extensions
	 *
	 * @param bool $get_types
	 * @param bool $ignore_zip
	 * @return array
	 */
	public function get_allowed_types(bool $get_types = false, bool $ignore_zip = false): array
	{
		$extensions = $types = [];
		if ($this->gallery_config->get('allow_jpg'))
		{
			$types[] = $this->language->lang('FILETYPES_JPG');
			$extensions[] = 'jpg';
			$extensions[] = 'jpeg';
		}
		if ($this->gallery_config->get('allow_gif'))
		{
			$types[] = $this->language->lang('FILETYPES_GIF');
			$extensions[] = 'gif';
		}
		if ($this->gallery_config->get('allow_png'))
		{
			$types[] = $this->language->lang('FILETYPES_PNG');
			$extensions[] = 'png';
		}
		if ($this->gallery_config->get('allow_webp'))
		{
			$types[] = $this->language->lang('FILETYPES_WEBP');
			$extensions[] = 'webp';
		}
		if ($this->allow_zip && !$ignore_zip && $this->gallery_config->get('allow_zip'))
		{
			$types[] = $this->language->lang('FILETYPES_ZIP');
			$extensions[] = 'zip';
		}

		return ($get_types) ? $types : $extensions;
	}

	/**
	* Generate some kind of check so users only complete the upload for their images
	*/
	public function generate_hidden_fields(): array
	{
		$checks = [];
		foreach ($this->images as $image_id)
		{
			$checks[] = $image_id . '$' . $this->image_data[$image_id]['image_filename'];
		}
		return $checks;
	}

}
