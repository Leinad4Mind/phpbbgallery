<?php

namespace forumhulp\uploadimage\controller;

use phpbb\cache\service as cache_service;
use phpbb\config\config;
use phpbb\files\factory;
use phpbb\filesystem\filesystem_interface;
use phpbb\log\log_interface;
use phpbb\pagination;
use phpbb\path_helper;
use phpbb\plupload\plupload;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	private const ALLOWED_EXTENSIONS = ['gif', 'jpg', 'jpeg', 'png'];
	private const FORM_KEY = 'acp_uploadimage';

	private config $config;
	private request_interface $request;
	private user $user;
	private template $template;
	private path_helper $path_helper;
	private cache_service $cache;
	private pagination $pagination;
	private log_interface $log;
	private plupload $plupload;
	private factory $files_factory;
	private filesystem_interface $filesystem;
	private string $root_path;
	private string $u_action = '';

	public function __construct(
		config $config,
		request_interface $request,
		user $user,
		template $template,
		path_helper $path_helper,
		cache_service $cache,
		pagination $pagination,
		log_interface $log,
		plupload $plupload,
		factory $files_factory,
		filesystem_interface $filesystem,
		string $root_path
	)
	{
		$this->config = $config;
		$this->request = $request;
		$this->user = $user;
		$this->template = $template;
		$this->path_helper = $path_helper;
		$this->cache = $cache;
		$this->pagination = $pagination;
		$this->log = $log;
		$this->plupload = $plupload;
		$this->files_factory = $files_factory;
		$this->filesystem = $filesystem;
		$this->root_path = $root_path;
	}

	public function display_images(): void
	{
		$this->user->add_lang('posting');
		$folder = $this->configured_folder();
		$directory = $this->ensure_upload_directory();
		$max_filesize = $this->maximum_filesize();
		$form_enctype = $this->uploads_enabled() ? ' enctype="multipart/form-data"' : '';

		add_form_key(self::FORM_KEY);
		$this->template->assign_vars([
			'S_FORM_ENCTYPE_IU' => $form_enctype,
			'S_POST_ACTION' => $this->u_action,
			'FILESIZE' => $max_filesize,
			'IMG_FOLDER' => $folder,
			'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN' => $this->user->lang(
				'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN',
				$folder
			),
			'S_ATTACH_DATA' => '[]',
		]);

		if ($form_enctype !== '')
		{
			$this->plupload->configure($this->cache, $this->template, $this->u_action, 0, 10);
			$this->template->assign_var(
				'FILTERS',
				sprintf("{title: 'Images', extensions: 'gif,jpg,jpeg,png', max_file_size: %d}", $max_filesize)
			);
		}

		$images = $this->load_images($directory, $folder);
		$directory_size = array_sum(array_column($images, 'size'));
		$search_value = $this->request->is_set_post('search')
			? $this->request->variable('keyword', '')
			: $this->request->variable('keywords', '');
		$search = htmlspecialchars_decode($search_value, ENT_QUOTES);

		if ($search !== '')
		{
			$images = array_values(array_filter(
				$images,
				static fn (array $image): bool => stripos($image['filename'], $search) !== false
			));
		}

		$sort_key = $this->request->variable('sk', 'n');
		if (!in_array($sort_key, ['n', 's', 'f'], true))
		{
			$sort_key = 'n';
		}
		$sort_direction = $this->request->variable('sd', 'a') === 'd' ? 'd' : 'a';
		$this->sort_images($images, $sort_key, $sort_direction);

		$image_count = count($images);
		$per_page = 10;
		$start = $this->pagination->validate_start(
			max(0, $this->request->variable('start', 0)),
			$per_page,
			$image_count
		);
		$base_url = $this->u_action . '&amp;sk=' . $sort_key . '&amp;sd=' . $sort_direction;
		if ($search !== '')
		{
			$base_url .= '&amp;keywords=' . urlencode($search);
		}
		$this->pagination->generate_template_pagination(
			$base_url,
			'pagination',
			'start',
			$image_count,
			$per_page,
			$start
		);

		foreach (array_slice($images, $start, $per_page) as $offset => $image)
		{
			$this->template->assign_block_vars('image_list', [
				'ID' => $start + $offset + 1,
				'PATH' => htmlspecialchars($image['public_path'], ENT_QUOTES, 'UTF-8'),
				'IMAGE_URL' => $image['url'],
				'FILENAME' => htmlspecialchars($image['filename'], ENT_QUOTES, 'UTF-8'),
				'NAME' => htmlspecialchars($image['name'], ENT_QUOTES, 'UTF-8'),
				'WIDTH' => $image['width'],
				'HEIGHT' => $image['height'],
				'SIZE' => get_formatted_filesize($image['size']),
				'DELETE_URL' => $this->u_action . '&amp;action=delete&amp;image_id=' . urlencode($image['filename']),
			]);
		}

		$this->template->assign_vars([
			'U_ACTION' => $this->u_action,
			'DIR_SIZE' => get_formatted_filesize($directory_size),
			'KEYWORD' => $search_value,
			'S_SORT_KEY' => $sort_key,
			'S_SORT_DIR' => $sort_direction,
			'TOTAL_IMAGES' => $image_count,
		]);
	}

	public function rename_folder(): void
	{
		$new_folder = htmlspecialchars_decode(
			$this->request->variable('img_folder', ''),
			ENT_QUOTES
		);
		if (!$this->valid_folder($new_folder))
		{
			trigger_error($this->user->lang['FORM_INVALID'], E_USER_WARNING);
		}

		$old_folder = $this->configured_folder();
		if ($new_folder === $old_folder)
		{
			return;
		}

		$current = $this->ensure_upload_directory();
		$images_root = $this->images_root();
		$target = $images_root . DIRECTORY_SEPARATOR . $new_folder;
		if (file_exists($target))
		{
			trigger_error($this->user->lang['FORM_INVALID'], E_USER_WARNING);
		}

		try
		{
			$this->filesystem->rename($current, $target, false);
		}
		catch (\phpbb\filesystem\exception\filesystem_exception $exception)
		{
			trigger_error($this->user->lang['GENERAL_ERROR'], E_USER_WARNING);
		}

		if (!is_dir($target))
		{
			trigger_error($this->user->lang['GENERAL_ERROR'], E_USER_WARNING);
		}

		$this->config->set('uploadimage_folder', $new_folder);
	}

	public function delete_image(string $image_id): void
	{
		$filename = $this->normalise_filename(htmlspecialchars_decode($image_id, ENT_QUOTES));
		if ($filename === null)
		{
			trigger_error($this->user->lang['FORM_INVALID'], E_USER_WARNING);
		}

		$directory = $this->ensure_upload_directory();
		$path = $directory . DIRECTORY_SEPARATOR . $filename;
		$real_path = realpath($path);
		if (
			$real_path === false ||
			is_link($path) ||
			!is_file($real_path) ||
			$this->normalise_path(dirname($real_path)) !== $this->normalise_path($directory)
		)
		{
			trigger_error($this->user->lang['FORM_INVALID'], E_USER_WARNING);
		}

		try
		{
			$this->filesystem->remove($real_path);
		}
		catch (\phpbb\filesystem\exception\filesystem_exception $exception)
		{
			trigger_error($this->user->lang['GENERAL_ERROR'], E_USER_WARNING);
		}

		if (file_exists($real_path))
		{
			trigger_error($this->user->lang['GENERAL_ERROR'], E_USER_WARNING);
		}

		$this->log->add(
			'admin',
			(int) $this->user->data['user_id'],
			$this->user->ip,
			'ACP_IMAGE_DELETED_LOG',
			time(),
			[$filename]
		);
	}

	public function sanitise_attachment_data(array $files): array
	{
		$directory = $this->ensure_upload_directory();
		$result = [];
		$seen_filenames = [];
		$seen_ids = [];
		foreach ($files as $index => $file)
		{
			if (!is_array($file))
			{
				continue;
			}

			$filename = $this->normalise_filename((string) ($file['real_filename'] ?? ''));
			$attach_id = (string) ($file['attach_id'] ?? '');
			if ($filename === null || !ctype_digit($attach_id) || (int) $attach_id < 1)
			{
				continue;
			}
			if (isset($seen_filenames[$filename]) || isset($seen_ids[$attach_id]))
			{
				continue;
			}

			$path = $directory . DIRECTORY_SEPARATOR . $filename;
			$real_path = realpath($path);
			if (
				$real_path === false ||
				is_link($path) ||
				!is_file($real_path) ||
				$this->normalise_path(dirname($real_path)) !== $this->normalise_path($directory) ||
				!$this->valid_image_content($real_path, $filename)
			)
			{
				continue;
			}

			$seen_filenames[$filename] = true;
			$seen_ids[$attach_id] = true;
			$result[$index] = [
				'attach_id' => (int) $attach_id,
				'is_orphan' => 1,
				'real_filename' => $filename,
				'filesize' => (int) filesize($real_path),
			];
		}

		return $result;
	}

	public function set_page_url(string $u_action): void
	{
		$this->u_action = $u_action;
	}

	public function add_image(): void
	{
		$this->user->add_lang('posting');
		$max_filesize = $this->maximum_filesize();
		$upload = $this->files_factory->get('upload')
			->set_error_prefix('AVATAR_')
			->set_allowed_extensions(self::ALLOWED_EXTENSIONS)
			->set_max_filesize($max_filesize)
			->set_allowed_dimensions(0, 0, 0, 0)
			->set_disallowed_content(
				isset($this->config['mime_triggers'])
					? explode('|', $this->config['mime_triggers'])
					: false
			);
		$file = $upload->handle_upload('files.types.form', 'fileupload');

		if (!is_object($file))
		{
			$this->send_upload_error([$this->general_upload_error()]);
		}
		if (!empty($file->error))
		{
			$this->send_upload_error($file->error);
		}

		$file->clean_filename('real');
		$filename = $this->normalise_filename((string) $file->get('realname'));
		$temporary_file = (string) $file->get('filename');
		if ($filename === null || !$this->valid_image_content($temporary_file, $filename))
		{
			$this->send_upload_error([$this->user->lang['ATTACHED_IMAGE_NOT_IMAGE']]);
		}

		$this->ensure_upload_directory();
		$moved = $file->move_file(
			'images/' . $this->configured_folder(),
			false,
			false,
			filesystem_interface::CHMOD_READ | filesystem_interface::CHMOD_WRITE
		);
		if (!$moved || !empty($file->error))
		{
			$file->remove();
			$this->send_upload_error($file->error ?: [$this->general_upload_error()]);
		}

		$attachment_data = $this->request->variable(
			'attachment_data',
			[0 => ['' => '']],
			true,
			request_interface::POST
		);
		$attachment_data = array_values($this->sanitise_attachment_data($attachment_data));
		$existing_ids = array_column($attachment_data, 'attach_id');
		do
		{
			$attach_id = random_int(1000, 2147483647);
		}
		while (in_array($attach_id, $existing_ids, true));

		$entry = [
			'attach_id' => $attach_id,
			'is_orphan' => 1,
			'real_filename' => $filename,
			'filesize' => (int) $file->get('filesize'),
		];
		$download_url = $this->public_base_url() . rawurlencode($filename);
		$attachment_data = array_merge([$entry], $attachment_data);

		if ($this->plupload->is_active())
		{
			$response = new \phpbb\json_response();
			$response->send(['data' => $attachment_data, 'download_url' => $download_url]);
		}
	}

	private function load_images(string $directory, string $folder): array
	{
		$images = [];
		$iterator = new \FilesystemIterator($directory, \FilesystemIterator::SKIP_DOTS);
		foreach ($iterator as $file_info)
		{
			if (!$file_info->isFile() || $file_info->isLink())
			{
				continue;
			}

			$filename = $this->normalise_filename($file_info->getFilename());
			if ($filename === null)
			{
				continue;
			}
			if (!$this->valid_image_content($file_info->getPathname(), $filename))
			{
				continue;
			}

			$image_info = @getimagesize($file_info->getPathname());
			$width = is_array($image_info) ? (int) $image_info[0] : 0;
			$height = is_array($image_info) ? (int) $image_info[1] : 0;
			$size = (int) $file_info->getSize();
			$images[] = [
				'filename' => $filename,
				'name' => ucfirst(str_replace('_', ' ', pathinfo($filename, PATHINFO_FILENAME))),
				'width' => $width,
				'height' => $height,
				'size' => $size,
				'public_path' => 'images/' . $folder . '/' . $filename,
				'url' => $this->public_base_url() . rawurlencode($filename),
			];
		}

		return $images;
	}

	private function sort_images(array &$images, string $sort_key, string $sort_direction): void
	{
		usort($images, static function (array $left, array $right) use ($sort_key, $sort_direction): int
		{
			switch ($sort_key)
			{
				case 's':
					$result = $left['size'] <=> $right['size'];
				break;

				case 'f':
					$result = [$left['width'], $left['height']] <=> [$right['width'], $right['height']];
				break;

				case 'n':
				default:
					$result = strnatcasecmp($left['name'], $right['name']);
				break;
			}

			return $sort_direction === 'd' ? -$result : $result;
		});
	}

	private function normalise_filename(string $filename): ?string
	{
		if (
			$filename === '' ||
			str_contains($filename, '/') ||
			str_contains($filename, '\\') ||
			!preg_match('~\A[\p{L}\p{N}][\p{L}\p{N}._ -]{0,200}\.(?:gif|jpe?g|png)\z~uiD', $filename)
		)
		{
			return null;
		}

		return $filename;
	}

	private function valid_image_content(string $path, string $filename): bool
	{
		$image_info = @getimagesize($path);
		if (!is_array($image_info) || empty($image_info[0]) || empty($image_info[1]))
		{
			return false;
		}

		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$types = [
			IMAGETYPE_GIF => ['gif'],
			IMAGETYPE_JPEG => ['jpg', 'jpeg'],
			IMAGETYPE_PNG => ['png'],
		];

		return isset($types[$image_info[2]]) && in_array($extension, $types[$image_info[2]], true);
	}

	private function ensure_upload_directory(): string
	{
		$directory = $this->images_root() . DIRECTORY_SEPARATOR . $this->configured_folder();
		if (!is_dir($directory))
		{
			try
			{
				$this->filesystem->mkdir($directory, 0775);
			}
			catch (\phpbb\filesystem\exception\filesystem_exception $exception)
			{
				trigger_error($this->user->lang['GENERAL_ERROR'], E_USER_WARNING);
			}
		}

		$real_directory = realpath($directory);
		if (
			$real_directory === false ||
			$this->normalise_path(dirname($real_directory)) !== $this->normalise_path($this->images_root())
		)
		{
			trigger_error($this->user->lang['GENERAL_ERROR'], E_USER_WARNING);
		}

		return $real_directory;
	}

	private function images_root(): string
	{
		$images_root = realpath($this->root_path . 'images');
		if ($images_root === false || !is_dir($images_root))
		{
			trigger_error($this->user->lang['GENERAL_ERROR'], E_USER_WARNING);
		}

		return $images_root;
	}

	private function configured_folder(): string
	{
		$folder = (string) $this->config['uploadimage_folder'];
		return $this->valid_folder($folder) ? $folder : 'ui';
	}

	private function valid_folder(string $folder): bool
	{
		return (bool) preg_match('/\A[A-Za-z0-9][A-Za-z0-9_-]{0,63}\z/D', $folder);
	}

	private function public_base_url(): string
	{
		return $this->path_helper->get_web_root_path() .
			'images/' . rawurlencode($this->configured_folder()) . '/';
	}

	private function normalise_path(string $path): string
	{
		return rtrim(str_replace('\\', '/', $path), '/');
	}

	private function maximum_filesize(): int
	{
		$limits = array_filter([
			$this->parse_size((string) ini_get('upload_max_filesize')),
			$this->parse_size((string) ini_get('post_max_size')),
			isset($this->config['max_filesize']) ? (int) $this->config['max_filesize'] : 0,
		], static fn (int $limit): bool => $limit > 0);
		if ($limits === [])
		{
			return 0;
		}

		return min($limits);
	}

	private function parse_size(string $value): int
	{
		if (!preg_match('/\A(\d+)([KMG])?\z/iD', trim($value), $matches))
		{
			return 0;
		}

		$size = (int) $matches[1];
		$unit = strtoupper($matches[2] ?? '');
		$multiplier = ['' => 1, 'K' => 1024, 'M' => 1048576, 'G' => 1073741824];

		return $size * $multiplier[$unit];
	}

	private function uploads_enabled(): bool
	{
		$value = strtolower((string) ini_get('file_uploads'));
		return $value !== '0' && $value !== 'off' && $value !== '';
	}

	private function general_upload_error(): string
	{
		return $this->user->lang('GENERAL_UPLOAD_ERROR', 'images/' . $this->configured_folder());
	}

	private function send_upload_error(array $errors): void
	{
		$errors = array_values(array_filter(array_map(
			static fn ($error): string => htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8'),
			$errors
		)));
		$message = $errors ? implode('<br />', $errors) : $this->general_upload_error();

		if ($this->plupload->is_active() || $this->request->is_ajax())
		{
			$response = new \phpbb\json_response();
			$response->send(['error' => ['message' => $message]]);
		}

		trigger_error($message, E_USER_WARNING);
	}
}
