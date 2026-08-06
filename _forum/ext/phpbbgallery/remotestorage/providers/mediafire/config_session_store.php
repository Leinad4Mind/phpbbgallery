<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\mediafire;

use phpbb\db\driver\driver_interface;

/** phpBB config-backed MediaFire signing state protected by a process lock. */
final class config_session_store implements session_store_interface
{
	public function __construct(
		private \ArrayAccess $config,
		private string $lock_file,
		private ?driver_interface $db = null,
		private string $config_table = ''
	)
	{
		if ($lock_file === '' || strlen($lock_file) > 4096 || str_contains($lock_file, chr(0)))
		{
			throw new \InvalidArgumentException('The MediaFire session lock path is invalid.');
		}
		if ($db !== null && preg_match('/^[A-Za-z0-9_]+$/D', $config_table) !== 1)
		{
			throw new \InvalidArgumentException('The phpBB config table name is invalid.');
		}
	}

	public function synchronized(\Closure $operation): mixed
	{
		$directory = dirname($this->lock_file);
		if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory))
		{
			throw new \RuntimeException('Could not create the MediaFire session lock directory.');
		}
		$lock = fopen($this->lock_file, 'c+b');
		if ($lock === false || !flock($lock, LOCK_EX))
		{
			if (is_resource($lock))
			{
				fclose($lock);
			}
			throw new \RuntimeException('Could not lock the MediaFire session state.');
		}
		try
		{
			return $operation();
		}
		finally
		{
			flock($lock, LOCK_UN);
			fclose($lock);
		}
	}

	public function load(): array
	{
		if ($this->db !== null)
		{
			return $this->load_database();
		}

		return [
			'session_token' => (string) ($this->config['phpbb_gallery_mediafire_session_token'] ?? ''),
			'secret_key' => (int) ($this->config['phpbb_gallery_mediafire_secret_key'] ?? 0),
			'time' => (string) ($this->config['phpbb_gallery_mediafire_session_time'] ?? ''),
			'issued_at' => (int) ($this->config['phpbb_gallery_mediafire_session_issued_at'] ?? 0),
		];
	}

	public function save(string $session_token, int $secret_key, string $time, int $issued_at): void
	{
		$this->set('phpbb_gallery_mediafire_session_token', '');
		$this->set('phpbb_gallery_mediafire_secret_key', (string) $secret_key);
		$this->set('phpbb_gallery_mediafire_session_time', $time);
		$this->set('phpbb_gallery_mediafire_session_issued_at', (string) $issued_at);
		$this->set('phpbb_gallery_mediafire_session_token', $session_token);
	}

	public function save_secret_key(int $secret_key): void
	{
		$this->set('phpbb_gallery_mediafire_secret_key', (string) $secret_key);
	}

	/** @return array{session_token: string, secret_key: int, time: string, issued_at: int} */
	private function load_database(): array
	{
		$names = [
			'phpbb_gallery_mediafire_session_token',
			'phpbb_gallery_mediafire_secret_key',
			'phpbb_gallery_mediafire_session_time',
			'phpbb_gallery_mediafire_session_issued_at',
		];
		$values = array_fill_keys($names, '');
		$sql = 'SELECT config_name, config_value
			FROM ' . $this->config_table . '
			WHERE ' . $this->db->sql_in_set('config_name', $names);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (is_array($row) && array_key_exists((string) ($row['config_name'] ?? ''), $values))
			{
				$values[(string) $row['config_name']] = (string) ($row['config_value'] ?? '');
			}
		}
		$this->db->sql_freeresult($result);

		return [
			'session_token' => $values['phpbb_gallery_mediafire_session_token'],
			'secret_key' => (int) $values['phpbb_gallery_mediafire_secret_key'],
			'time' => $values['phpbb_gallery_mediafire_session_time'],
			'issued_at' => (int) $values['phpbb_gallery_mediafire_session_issued_at'],
		];
	}

	private function set(string $key, string $value): void
	{
		if (method_exists($this->config, 'set'))
		{
			$this->config->set($key, $value);
			return;
		}
		$this->config[$key] = $value;
	}
}
