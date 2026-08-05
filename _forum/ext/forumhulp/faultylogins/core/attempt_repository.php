<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\core;

use phpbb\db\driver\driver_interface;

class attempt_repository
{
	const LEGACY_OPERATION = 'LOG_FAULTY_LOGINS';

	/** @var driver_interface */
	protected $db;

	/** @var string */
	protected $table;

	/** @var string */
	protected $log_table;

	public function __construct(driver_interface $db, $table, $log_table)
	{
		$this->db = $db;
		$this->table = $table;
		$this->log_table = $log_table;
	}

	public function add(array $attempt)
	{
		$sql_ary = [
			'attempt_time' => (int) $attempt['attempt_time'],
			'actor_user_id' => (int) $attempt['actor_user_id'],
			'attempted_user_id' => (int) $attempt['attempted_user_id'],
			'attempted_username' => (string) $attempt['attempted_username'],
			'ip_address' => (string) $attempt['ip_address'],
			'login_status' => (int) $attempt['login_status'],
			'error_key' => (string) $attempt['error_key'],
			'error_text' => (string) $attempt['error_text'],
			'password_cipher' => (string) $attempt['password_cipher'],
			'password_truncated' => !empty($attempt['password_truncated']) ? 1 : 0,
		];

		$this->db->sql_query('INSERT INTO ' . $this->table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));

		return (int) $this->db->sql_nextid();
	}

	public function count()
	{
		$sql = 'SELECT COUNT(attempt_id) AS total
			FROM ' . $this->table;
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $total;
	}

	public function get($limit, $offset)
	{
		$sql = 'SELECT *
			FROM ' . $this->table . '
			ORDER BY attempt_time DESC, attempt_id DESC';
		$result = $this->db->sql_query_limit($sql, max(1, (int) $limit), max(0, (int) $offset));
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}

	public function delete_all()
	{
		$this->db->sql_query('DELETE FROM ' . $this->table);

		return (int) $this->db->sql_affectedrows();
	}

	public function prune_before($timestamp)
	{
		$sql = 'DELETE FROM ' . $this->table . '
			WHERE attempt_time < ' . (int) $timestamp;
		$this->db->sql_query($sql);

		return (int) $this->db->sql_affectedrows();
	}

	public function count_legacy()
	{
		$sql = 'SELECT COUNT(log_id) AS total
			FROM ' . $this->log_table . "
			WHERE log_operation = '" . $this->db->sql_escape(self::LEGACY_OPERATION) . "'";
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $total;
	}

	public function migrate_legacy(crypto_manager $crypto)
	{
		$migrated = 0;
		$removed = 0;
		do
		{
			$sql = 'SELECT log_id, user_id, log_ip, log_time, log_data
				FROM ' . $this->log_table . "
				WHERE log_operation = '" . $this->db->sql_escape(self::LEGACY_OPERATION) . "'
				ORDER BY log_id ASC";
			$result = $this->db->sql_query_limit($sql, 250);
			$rows = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$rows[] = $row;
			}
			$this->db->sql_freeresult($result);
			if (!$rows)
			{
				break;
			}

			$this->db->sql_transaction('begin');
			try
			{
				$delete_ids = [];
				foreach ($rows as $row)
				{
					$delete_ids[] = (int) $row['log_id'];
					$data = @unserialize($row['log_data'], ['allowed_classes' => false]);
					if (!is_array($data) || !array_key_exists(1, $data))
					{
						continue;
					}

					$username = $this->limit_text(isset($data[0]) ? $data[0] : '', 180);
					$password = substr((string) $data[1], 0, 4096);
					$timestamp = (int) $row['log_time'];
					$ip = $this->limit_text($row['log_ip'], 40);
					$context = [
						'username' => $username,
						'ip' => $ip,
						'time' => $timestamp,
						'status' => 0,
					];
					$ciphertext = $crypto->encrypt_password($password, $context);
					if ($ciphertext === false)
					{
						throw new \RuntimeException('Unable to encrypt a legacy log entry.');
					}

					$this->add([
						'attempt_time' => $timestamp,
						'actor_user_id' => defined('ANONYMOUS') ? ANONYMOUS : 1,
						'attempted_user_id' => (int) $row['user_id'],
						'attempted_username' => $username,
						'ip_address' => $ip,
						'login_status' => 0,
						'error_key' => 'FAULTYLOGINS_LEGACY_REASON',
						'error_text' => $this->limit_text(isset($data[2]) ? strip_tags((string) $data[2]) : '', 255),
						'password_cipher' => $ciphertext,
						'password_truncated' => strlen((string) $data[1]) > 4096,
					]);
					$crypto->wipe($password);
					$migrated++;
				}

				$sql = 'DELETE FROM ' . $this->log_table . '
					WHERE ' . $this->db->sql_in_set('log_id', $delete_ids);
				$this->db->sql_query($sql);
				$removed += count($delete_ids);
				$this->db->sql_transaction('commit');
			}
			catch (\Throwable $exception)
			{
				$this->db->sql_transaction('rollback');
				throw $exception;
			}
		}
		while (count($rows) === 250);

		return ['migrated' => $migrated, 'removed' => $removed];
	}

	protected function limit_text($value, $length)
	{
		$value = (string) $value;
		if (function_exists('utf8_substr'))
		{
			return utf8_substr($value, 0, $length);
		}

		return substr($value, 0, $length);
	}
}
