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
 * Persist the state of a batched export between requests.
 *
 * A single export can span many requests, so the cursor into the image list, the
 * archive it is filling and the errors collected along the way all have to survive
 * a redirect. The state lives in one JSON file per job inside the export directory,
 * which also lets the UCP list a member's jobs and the cron task find stale ones
 * without a database table of its own.
 */
class job_storage
{
	/** Hidden prefix so a state file is never mistaken for a finished archive. */
	private const STATE_PREFIX = '.phpbbgallery_export_';
	private const STATE_SUFFIX = '.json';

	/** A job that no longer fits in this much JSON is refused rather than truncated. */
	private const MAX_STATE_SIZE = 8388608;

	/** Absolute ceiling, independent of the configurable per-scope limits. */
	public const MAX_IMAGES = 50000;
	private const MAX_ERRORS = 10000;

	public const SCOPE_ACP = 'acp';
	public const SCOPE_UCP = 'ucp';

	public const DELIVERY_DOWNLOAD = 'download';
	public const DELIVERY_SERVER = 'server';

	public const STATUS_RUNNING = 'running';
	public const STATUS_READY = 'ready';

	/** @var string Export directory, with a trailing separator */
	private string $directory;

	/**
	 * Constructor
	 *
	 * @param string $directory Directory holding the archives and their state files
	 */
	public function __construct(string $directory)
	{
		$this->directory = rtrim(path::resolve($directory), '/\\') . DIRECTORY_SEPARATOR;
	}

	/**
	 * Return the export directory.
	 *
	 * @return string
	 */
	public function get_directory(): string
	{
		return $this->directory;
	}

	/**
	 * Generate an unguessable job identifier.
	 *
	 * @return string
	 */
	public function create_job_id(): string
	{
		return bin2hex(random_bytes(16));
	}

	/**
	 * Resolve the state file of a job.
	 *
	 * @param string $job_id Job identifier
	 * @return string|false Path, or false when the identifier is malformed
	 */
	public function get_state_path(string $job_id): string|false
	{
		if (!$this->is_valid_job_id($job_id))
		{
			return false;
		}

		return $this->directory . self::STATE_PREFIX . $job_id . self::STATE_SUFFIX;
	}

	/**
	 * Resolve the archive of a job.
	 *
	 * @param array $state Job state
	 * @return string|false Path, or false when the state carries no usable archive name
	 */
	public function get_archive_path(array $state): string|false
	{
		if (!isset($state['archive']) || !is_string($state['archive']) || !$this->is_valid_archive_name($state['archive']))
		{
			return false;
		}

		return $this->directory . $state['archive'];
	}

	/**
	 * Store the state of a job.
	 *
	 * @param string $job_id Job identifier
	 * @param array  $state  Job state
	 * @return bool
	 */
	public function write_state(string $job_id, array $state): bool
	{
		$state_path = $this->get_state_path($job_id);
		if ($state_path === false || !$this->validate_state($state) || $state['job_id'] !== $job_id || !is_dir($this->directory) || is_link($state_path))
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
	 * Read back the state of a job.
	 *
	 * @param string $job_id Job identifier
	 * @return array|false Job state, or false when it is missing or unusable
	 */
	public function read_state(string $job_id): array|false
	{
		$state_path = $this->get_state_path($job_id);
		if ($state_path === false || is_link($state_path) || !is_file($state_path))
		{
			return false;
		}

		$handle = @fopen($state_path, 'rb');
		if ($handle === false)
		{
			return false;
		}

		if (!flock($handle, LOCK_SH))
		{
			fclose($handle);
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

	/**
	 * Delete the state file of a job, leaving its archive alone.
	 *
	 * @param string $job_id Job identifier
	 * @return bool
	 */
	public function remove_state(string $job_id): bool
	{
		$state_path = $this->get_state_path($job_id);
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

	/**
	 * Delete a job completely: its archive and its state file.
	 *
	 * @param array $state Job state
	 * @return bool
	 */
	public function remove_job(array $state): bool
	{
		if (!$this->validate_state($state))
		{
			return false;
		}

		$archive_path = $this->get_archive_path($state);
		if ($archive_path !== false && (file_exists($archive_path) || is_link($archive_path)) && !@unlink($archive_path))
		{
			return false;
		}

		return $this->remove_state($state['job_id']);
	}

	/**
	 * Read every readable job in the export directory, newest first.
	 *
	 * @return array Job states indexed by job identifier
	 */
	public function all_jobs(): array
	{
		$files = @scandir($this->directory);
		if ($files === false)
		{
			return [];
		}

		$pattern = '/^' . preg_quote(self::STATE_PREFIX, '/') . '([a-f0-9]{32})' . preg_quote(self::STATE_SUFFIX, '/') . '$/';

		$jobs = [];
		foreach ($files as $file)
		{
			if (!preg_match($pattern, $file, $matches))
			{
				continue;
			}

			$state = $this->read_state($matches[1]);
			if ($state !== false)
			{
				$jobs[$state['job_id']] = $state;
			}
		}

		uasort($jobs, static function (array $a, array $b): int {
			return $b['created'] <=> $a['created'];
		});

		return $jobs;
	}

	/**
	 * Read the jobs belonging to one member.
	 *
	 * @param int $user_id Member the jobs belong to
	 * @return array Job states indexed by job identifier
	 */
	public function list_for_owner(int $user_id): array
	{
		return array_filter($this->all_jobs(), static function (array $state) use ($user_id): bool {
			return $state['owner_id'] === $user_id;
		});
	}

	/**
	 * Find the jobs the cron task may remove.
	 *
	 * Archives left on the server were asked for precisely so they could be collected
	 * later over FTP, so they are never pruned on a timer - only an explicit delete in
	 * the ACP removes them.
	 *
	 * @param int      $ttl Seconds a downloadable job is kept
	 * @param int|null $now Current timestamp, for testing
	 * @return array Job states indexed by job identifier
	 */
	public function expired(int $ttl, ?int $now = null): array
	{
		$now = $now ?? time();

		return array_filter($this->all_jobs(), static function (array $state) use ($ttl, $now): bool {
			return $state['delivery'] === self::DELIVERY_DOWNLOAD && ($state['created'] + $ttl) <= $now;
		});
	}

	/**
	 * Claim an unused archive name, appending a counter when the name is taken.
	 *
	 * The placeholder is created atomically so two exports started in the same minute
	 * cannot settle on the same file.
	 *
	 * @param string $desired Preferred basename, extension included
	 * @return string|false Claimed basename, or false when no free name could be taken
	 */
	public function reserve_archive_name(string $desired): string|false
	{
		if (!$this->is_valid_archive_name($desired) || !is_dir($this->directory))
		{
			return false;
		}

		$extension = '.zip';
		$stem = substr($desired, 0, -strlen($extension));

		for ($suffix = 0; $suffix <= 1000; $suffix++)
		{
			$candidate = $stem . ($suffix ? '_' . $suffix : '') . $extension;
			if (strlen($candidate) > 255)
			{
				return false;
			}

			$handle = @fopen($this->directory . $candidate, 'xb');
			if ($handle !== false)
			{
				fclose($handle);
				return $candidate;
			}
		}

		return false;
	}

	/**
	 * An archive name is only ever generated by this add-on, so it stays a plain
	 * ASCII basename: it must survive FTP clients and can never walk out of the
	 * export directory.
	 *
	 * @param string $name Archive basename
	 * @return bool
	 */
	public function is_valid_archive_name(string $name): bool
	{
		return preg_match('/^[A-Za-z0-9][A-Za-z0-9._-]{0,250}\.zip$/', $name) === 1 && strpos($name, '..') === false;
	}

	/**
	 * @param string $job_id Job identifier
	 * @return bool
	 */
	private function is_valid_job_id(string $job_id): bool
	{
		return preg_match('/^[a-f0-9]{32}$/', $job_id) === 1;
	}

	/**
	 * Reject any state that does not have exactly the expected keys and types, so a
	 * hand-edited or truncated file can never steer the export.
	 *
	 * @param array $state Job state
	 * @return bool
	 */
	private function validate_state(array $state): bool
	{
		$required_keys = [
			'job_id',
			'owner_id',
			'scope',
			'delivery',
			'archive',
			'created',
			'album_ids',
			'image_ids',
			'done',
			'total',
			'bytes',
			'status',
			'errors',
		];
		$state_keys = array_keys($state);
		sort($required_keys);
		sort($state_keys);
		if ($required_keys !== $state_keys)
		{
			return false;
		}

		if (!is_string($state['job_id']) || !$this->is_valid_job_id($state['job_id']))
		{
			return false;
		}
		if (!is_int($state['owner_id']) || $state['owner_id'] < 1 || !is_int($state['created']) || $state['created'] < 1)
		{
			return false;
		}
		if (!in_array($state['scope'], [self::SCOPE_ACP, self::SCOPE_UCP], true)
			|| !in_array($state['delivery'], [self::DELIVERY_DOWNLOAD, self::DELIVERY_SERVER], true)
			|| !in_array($state['status'], [self::STATUS_RUNNING, self::STATUS_READY], true))
		{
			return false;
		}
		// Members have no FTP access, so a member-created job may never claim a named
		// archive in the shared export directory.
		if ($state['scope'] === self::SCOPE_UCP && $state['delivery'] !== self::DELIVERY_DOWNLOAD)
		{
			return false;
		}
		if (!is_string($state['archive']) || !$this->is_valid_archive_name($state['archive']))
		{
			return false;
		}
		if (!is_int($state['done']) || $state['done'] < 0 || !is_int($state['total']) || $state['total'] < 0
			|| !is_int($state['bytes']) || $state['bytes'] < 0 || $state['done'] > $state['total'])
		{
			return false;
		}

		if (!$this->is_id_list($state['album_ids'], self::MAX_IMAGES) || !$this->is_id_list($state['image_ids'], self::MAX_IMAGES))
		{
			return false;
		}
		if ($state['total'] !== count($state['image_ids']))
		{
			return false;
		}

		if (!is_array($state['errors']) || $state['errors'] !== array_values($state['errors']) || count($state['errors']) > self::MAX_ERRORS)
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

	/**
	 * @param mixed $value   Candidate list
	 * @param int   $maximum Largest accepted number of entries
	 * @return bool
	 */
	private function is_id_list(mixed $value, int $maximum): bool
	{
		if (!is_array($value) || $value !== array_values($value) || count($value) > $maximum)
		{
			return false;
		}

		foreach ($value as $id)
		{
			if (!is_int($id) || $id < 1)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * @param mixed $value          Candidate string
	 * @param int   $maximum_length Largest accepted length in bytes
	 * @return bool
	 */
	private function is_valid_string(mixed $value, int $maximum_length): bool
	{
		return is_string($value) && strlen($value) <= $maximum_length && preg_match('//u', $value) === 1 && preg_match('/[\x00-\x1F\x7F]/', $value) !== 1;
	}
}
