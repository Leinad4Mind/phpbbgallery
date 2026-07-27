<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export;

/**
 * Drive an export from one request to the next.
 *
 * The ACP and the UCP differ only in who may start a job and where the finished
 * archive goes, so the batching itself lives here and both modules call into it.
 */
class runner
{
	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/** @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/** @var \phpbbgallery\export\export */
	protected export $export;

	/** @var \phpbbgallery\export\archive */
	protected archive $archive;

	/** @var \phpbbgallery\export\job_storage */
	protected job_storage $storage;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config              $config   Config object
	 * @param \phpbb\language\language          $language Language object
	 * @param \phpbbgallery\export\export       $export   Export data object
	 * @param \phpbbgallery\export\archive      $archive  Archive writer
	 * @param \phpbbgallery\export\job_storage  $storage  Job storage
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\language\language $language,
		export $export, archive $archive, job_storage $storage)
	{
		$this->config = $config;
		$this->language = $language;
		$this->export = $export;
		$this->archive = $archive;
		$this->storage = $storage;
	}

	/**
	 * Start a job, once the selection is known to be within the configured limits.
	 *
	 * @param int    $owner_id  Member starting the export
	 * @param string $scope     job_storage::SCOPE_ACP or job_storage::SCOPE_UCP
	 * @param string $delivery  job_storage::DELIVERY_DOWNLOAD or job_storage::DELIVERY_SERVER
	 * @param array  $album_ids Albums the selection came from
	 * @param array  $selection Selection from the export data object
	 * @param string $label     Album name for a single-album export, otherwise empty
	 * @return array Either ['state' => array] or ['error' => string]
	 */
	public function create(int $owner_id, string $scope, string $delivery, array $album_ids, array $selection, string $label = ''): array
	{
		// Members have no way to fetch a file off the server themselves.
		if ($scope === job_storage::SCOPE_UCP)
		{
			$delivery = job_storage::DELIVERY_DOWNLOAD;
		}

		$image_ids = $selection['image_ids'];
		$bytes = (int) $selection['bytes'];

		if (empty($image_ids))
		{
			return ['error' => $this->language->lang('EXPORT_NO_IMAGES')];
		}

		$max_images = $this->get_max_images($scope);
		if (count($image_ids) > $max_images)
		{
			return ['error' => $this->language->lang('EXPORT_TOO_MANY_IMAGES', $max_images)];
		}

		$max_bytes = (int) $this->config['phpbb_gallery_export_max_bytes'];
		if ($max_bytes > 0 && $bytes > $max_bytes)
		{
			return ['error' => $this->language->lang('EXPORT_SIZE_LIMIT_EXCEEDED', get_formatted_filesize($max_bytes))];
		}

		// An archive that runs the partition out of space would take the board down
		// with it, so refuse before a single image is written.
		$free = @disk_free_space($this->storage->get_directory());
		if ($free !== false && $bytes > 0 && $free < ($bytes * 1.1))
		{
			return ['error' => $this->language->lang('EXPORT_NOT_ENOUGH_SPACE')];
		}

		$job_id = $this->storage->create_job_id();
		$created = time();

		if ($delivery === job_storage::DELIVERY_SERVER)
		{
			$archive_name = $this->storage->reserve_archive_name(archive::server_archive_name($label, $created));
		}
		else
		{
			$archive_name = $this->storage->reserve_archive_name(archive::download_archive_name($job_id));
		}

		if ($archive_name === false)
		{
			return ['error' => $this->language->lang('EXPORT_ARCHIVE_FAILED')];
		}

		$state = [
			'job_id' => $job_id,
			'owner_id' => $owner_id,
			'scope' => $scope,
			'delivery' => $delivery,
			'archive' => $archive_name,
			'created' => $created,
			'album_ids' => array_values(array_map('intval', $album_ids)),
			'image_ids' => $image_ids,
			'done' => 0,
			'total' => count($image_ids),
			'bytes' => 0,
			'status' => job_storage::STATUS_RUNNING,
			'errors' => [],
		];

		if (!$this->storage->write_state($job_id, $state))
		{
			return ['error' => $this->language->lang('EXPORT_STATE_FAILED')];
		}

		return ['state' => $state];
	}

	/**
	 * Add the next batch of images to a running job.
	 *
	 * @param array $state Job state
	 * @return array Either ['state' => array] or ['error' => string]
	 */
	public function step(array $state): array
	{
		if ($state['status'] === job_storage::STATUS_READY)
		{
			return ['state' => $state];
		}

		$archive_path = $this->storage->get_archive_path($state);
		if ($archive_path === false)
		{
			return ['error' => $this->language->lang('EXPORT_ARCHIVE_FAILED')];
		}

		$batch_size = $this->get_batch_size();
		$batch_ids = array_slice($state['image_ids'], $state['done'], $batch_size);

		if (!empty($batch_ids))
		{
			$rows = $this->export->get_rows($batch_ids);
			$result = $this->archive->append($archive_path, $rows, $state['done'] === 0);

			$state['bytes'] += $result['bytes'];
			$state['errors'] = array_merge($state['errors'], $this->describe_errors($result['errors']));

			// Rows that vanished from the database between selection and writing are
			// still consumed, otherwise the cursor would never reach the end.
			$state['done'] += count($batch_ids);
		}
		else
		{
			$state['done'] = $state['total'];
		}

		if ($state['done'] >= $state['total'])
		{
			$state['done'] = $state['total'];
			if (!$this->finish($state, $archive_path))
			{
				return ['error' => $this->language->lang('EXPORT_ARCHIVE_FAILED')];
			}
			$state['status'] = job_storage::STATUS_READY;
		}

		if (!$this->storage->write_state($state['job_id'], $state))
		{
			return ['error' => $this->language->lang('EXPORT_STATE_FAILED')];
		}

		return ['state' => $state];
	}

	/**
	 * Number of images written per request.
	 *
	 * @return int
	 */
	public function get_batch_size(): int
	{
		return max(1, (int) $this->config['phpbb_gallery_export_batch_size']);
	}

	/**
	 * Largest export the given scope may start.
	 *
	 * @param string $scope job_storage::SCOPE_ACP or job_storage::SCOPE_UCP
	 * @return int
	 */
	public function get_max_images(string $scope): int
	{
		$configured = $scope === job_storage::SCOPE_UCP
			? (int) $this->config['phpbb_gallery_export_ucp_max_images']
			: (int) $this->config['phpbb_gallery_export_max_images'];

		return max(1, min($configured, job_storage::MAX_IMAGES));
	}

	/**
	 * Whether members may export their own images.
	 *
	 * @return bool
	 */
	public function is_ucp_enabled(): bool
	{
		return (bool) $this->config['phpbb_gallery_export_ucp_enable'];
	}

	/**
	 * Write the manifest that turns a full archive into a finished export.
	 *
	 * @param array  $state        Job state
	 * @param string $archive_path Archive being completed
	 * @return bool
	 */
	protected function finish(array $state, string $archive_path): bool
	{
		$meta = [
			'generated_at' => gmdate('c', time()),
			'board_url' => generate_board_url(),
			'scope' => $state['scope'],
			'delivery' => $state['delivery'],
			'album_ids' => $state['album_ids'],
			'images' => $state['total'],
			'errors' => $state['errors'],
		];

		// The manifest is rebuilt from the same rows the archive was written from, so
		// the paths it lists are the paths that are actually in the file.
		$rows = [];
		foreach (array_chunk($state['image_ids'], $this->get_batch_size()) as $chunk)
		{
			$rows = array_merge($rows, $this->export->get_rows($chunk));
		}

		return $this->archive->write_manifest($archive_path, $rows, $meta);
	}

	/**
	 * Turn writer errors into messages that can be shown and stored.
	 *
	 * @param array $errors Errors from the archive writer
	 * @return array
	 */
	protected function describe_errors(array $errors): array
	{
		$messages = [];
		foreach ($errors as $error)
		{
			switch ($error['type'])
			{
				case 'missing':
					$messages[] = $this->language->lang('EXPORT_ERROR_MISSING_FILE', (int) $error['image_id'], (string) $error['file']);
				break;

				case 'unreadable':
					$messages[] = $this->language->lang('EXPORT_ERROR_UNREADABLE_FILE', (int) $error['image_id'], (string) $error['file']);
				break;

				default:
					$messages[] = $this->language->lang('EXPORT_ERROR_ARCHIVE', (string) $error['file']);
				break;
			}
		}

		return $messages;
	}
}
