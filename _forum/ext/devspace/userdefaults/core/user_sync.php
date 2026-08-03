<?php
/**
 * User Defaults extension for phpBB.
 *
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace devspace\userdefaults\core;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;

class user_sync
{
	const DEFAULT_BATCH_SIZE = 10;
	const MAX_BATCH_SIZE = 50;

	/** @var config */
	protected $config;

	/** @var driver_interface */
	protected $db;

	/** @var string */
	protected $users_table;

	/** @var settings_policy */
	protected $settings;

	/** @var notification_defaults */
	protected $notifications;

	public function __construct(config $config, driver_interface $db, $users_table, settings_policy $settings, notification_defaults $notifications)
	{
		$this->config = $config;
		$this->db = $db;
		$this->users_table = (string) $users_table;
		$this->settings = $settings;
		$this->notifications = $notifications;
	}

	public function run_batch($cursor, $batch_size = self::DEFAULT_BATCH_SIZE)
	{
		$cursor = max(0, (int) $cursor);
		$batch_size = max(1, min(self::MAX_BATCH_SIZE, (int) $batch_size));
		$total = $this->count_users();
		$rows = $this->users_after($cursor, $batch_size);

		if (!$rows)
		{
			return [
				'processed' => 0,
				'completed' => $total,
				'total' => $total,
				'next_cursor' => $cursor,
				'done' => true,
			];
		}

		$settings = $this->stored_settings();
		$notification_settings = $this->notifications->normalise_stored(
			isset($this->config[notification_defaults::CONFIG_KEY]) ? $this->config[notification_defaults::CONFIG_KEY] : null,
			$this->notifications->legacy_values($this->config)
		);
		$last_user_id = $cursor;

		$this->db->sql_transaction('begin');
		try
		{
			foreach ($rows as $row)
			{
				$user_id = (int) $row['user_id'];
				$values = $this->settings->user_values($settings, (int) $row['user_options']);
				$sql = 'UPDATE ' . $this->users_table . '
					SET ' . $this->db->sql_build_array('UPDATE', $values) . '
					WHERE user_id = ' . (int) $row['user_id'];
				$this->db->sql_query($sql);
				$this->notifications->apply_to_user($user_id, $notification_settings);
				$last_user_id = $user_id;
			}
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$remaining = $this->count_users($last_user_id);
		return [
			'processed' => count($rows),
			'completed' => max(0, $total - $remaining),
			'total' => $total,
			'next_cursor' => $last_user_id,
			'done' => $remaining === 0,
		];
	}

	protected function stored_settings()
	{
		$stored = [];
		foreach ($this->settings->defaults() as $key => $default)
		{
			if (isset($this->config[$key]))
			{
				$stored[$key] = $this->config[$key];
			}
		}
		return $this->settings->normalise_stored($stored);
	}

	protected function users_after($cursor, $limit)
	{
		$sql = 'SELECT user_id, user_options
			FROM ' . $this->users_table . '
			WHERE user_type IN (' . (int) USER_NORMAL . ', ' . (int) USER_FOUNDER . ')
				AND user_id > ' . (int) $cursor . '
			ORDER BY user_id ASC';
		$result = $this->db->sql_query_limit($sql, $limit);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		return $rows;
	}

	protected function count_users($after = null)
	{
		$sql = 'SELECT COUNT(user_id) AS total
			FROM ' . $this->users_table . '
			WHERE user_type IN (' . (int) USER_NORMAL . ', ' . (int) USER_FOUNDER . ')';
		if ($after !== null)
		{
			$sql .= ' AND user_id > ' . (int) $after;
		}
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);
		return $total;
	}
}
