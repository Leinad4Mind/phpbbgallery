<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\box;

use phpbb\db\driver\driver_interface;

/** phpBB config-backed Box credentials protected by a process lock. */
final class config_token_store implements token_store_interface
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
			throw new \InvalidArgumentException('The Box OAuth lock path is invalid.');
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
			throw new \RuntimeException('Could not create the Box OAuth lock directory.');
		}
		$lock = fopen($this->lock_file, 'c+b');
		if ($lock === false || !flock($lock, LOCK_EX))
		{
			if (is_resource($lock))
			{
				fclose($lock);
			}
			throw new \RuntimeException('Could not lock the Box OAuth credentials.');
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
			'access_token' => (string) ($this->config['phpbb_gallery_box_access_token'] ?? ''),
			'access_expires' => (int) ($this->config['phpbb_gallery_box_access_expires'] ?? 0),
			'refresh_token' => (string) ($this->config['phpbb_gallery_box_refresh_token'] ?? ''),
		];
	}

	public function save(string $access_token, int $access_expires, string $refresh_token): void
	{
		$this->set('phpbb_gallery_box_refresh_token', $refresh_token);
		$this->set('phpbb_gallery_box_access_token', $access_token);
		$this->set('phpbb_gallery_box_access_expires', (string) $access_expires);
	}

	/** @return array{access_token: string, access_expires: int, refresh_token: string} */
	private function load_database(): array
	{
		$names = [
			'phpbb_gallery_box_access_token',
			'phpbb_gallery_box_access_expires',
			'phpbb_gallery_box_refresh_token',
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
			'access_token' => $values['phpbb_gallery_box_access_token'],
			'access_expires' => (int) $values['phpbb_gallery_box_access_expires'],
			'refresh_token' => $values['phpbb_gallery_box_refresh_token'],
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
