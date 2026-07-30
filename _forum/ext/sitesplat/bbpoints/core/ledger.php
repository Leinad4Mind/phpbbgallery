<?php
/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\core;

use phpbb\cache\driver\driver_interface as cache_driver;
use phpbb\db\driver\driver_interface;
use phpbb\event\dispatcher_interface;
use sitesplat\bbpoints\exception\insufficient_funds;
use sitesplat\bbpoints\exception\invalid_operation;
use sitesplat\bbpoints\exception\operation_conflict;

/**
 * Public BBPoints balance and movement API.
 *
 * The existing movement table remains the source of truth. Operation keys make
 * external effects safe to retry, while a short payer-account lock prevents
 * simultaneous debits from spending the same balance twice.
 */
final class ledger
{
	public const SYSTEM_USER_ID = 0;
	private const OPERATION_KEY_PATTERN = '#^[A-Za-z0-9][A-Za-z0-9:._/-]{0,190}$#D';

	public function __construct(
		private driver_interface $db,
		private cache_driver $cache,
		private dispatcher_interface $dispatcher,
		private string $bbpoints_table,
		private string $operations_table,
		private string $users_table,
		private string $posts_table,
		private string $topics_table
	)
	{
	}

	/**
	 * Return the spendable balance calculated from public posts, topics and movements.
	 */
	public function get_balance(int $user_id): int
	{
		if (!$this->is_registered_user_id($user_id))
		{
			return 0;
		}

		$approved = defined('ITEM_APPROVED') ? (int) ITEM_APPROVED : 1;
		$sql = 'SELECT
			COALESCE((SELECT SUM(bbpoints) FROM ' . $this->posts_table . '
				WHERE post_visibility = ' . $approved . ' AND poster_id = ' . $user_id . '), 0)
			+ COALESCE((SELECT SUM(bbpoints) FROM ' . $this->topics_table . '
				WHERE topic_poster = ' . $user_id . '), 0)
			+ COALESCE((SELECT SUM(bbpoints) FROM ' . $this->bbpoints_table . '
				WHERE to_id = ' . $user_id . '), 0)
			- COALESCE((SELECT SUM(bbpoints) FROM ' . $this->bbpoints_table . '
				WHERE from_id = ' . $user_id . '), 0) AS total';
		$result = $this->db->sql_query($sql);
		$balance = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $balance;
	}

	/**
	 * Credit points created by the system.
	 */
	public function credit(int $to_user_id, int $amount, string $reason, string $operation_key): operation
	{
		return $this->record_without_debit(
			self::SYSTEM_USER_ID,
			$to_user_id,
			$amount,
			$reason,
			$operation_key
		);
	}

	/**
	 * Debit points to the system.
	 */
	public function debit(int $from_user_id, int $amount, string $reason, string $operation_key,
		bool $allow_negative = false): operation
	{
		return $this->record_with_debit(
			$from_user_id,
			self::SYSTEM_USER_ID,
			$amount,
			$reason,
			$operation_key,
			$allow_negative
		);
	}

	/**
	 * Transfer points between registered users.
	 */
	public function transfer(int $from_user_id, int $to_user_id, int $amount, string $reason,
		string $operation_key, bool $allow_negative = false): operation
	{
		return $this->record_with_debit(
			$from_user_id,
			$to_user_id,
			$amount,
			$reason,
			$operation_key,
			$allow_negative
		);
	}

	/**
	 * Retrieve an operation by its external idempotency key.
	 */
	public function get_operation(string $operation_key): ?operation
	{
		$this->validate_operation_key($operation_key);
		return $this->find_operation($operation_key);
	}

	public function has_operation(string $operation_key): bool
	{
		return $this->get_operation($operation_key) !== null;
	}

	private function record_without_debit(int $from_user_id, int $to_user_id, int $amount,
		string $reason, string $operation_key): operation
	{
		$this->validate_movement($from_user_id, $to_user_id, $amount, $operation_key);
		$this->assert_user_exists($to_user_id);

		return $this->record_atomically(
			$from_user_id,
			$to_user_id,
			$amount,
			$reason,
			$operation_key,
			false,
			false
		);
	}

	private function record_with_debit(int $from_user_id, int $to_user_id, int $amount,
		string $reason, string $operation_key, bool $allow_negative): operation
	{
		$this->validate_movement($from_user_id, $to_user_id, $amount, $operation_key);
		$this->assert_user_exists($from_user_id);
		if ($to_user_id !== self::SYSTEM_USER_ID)
		{
			$this->assert_user_exists($to_user_id);
		}

		return $this->record_atomically(
			$from_user_id,
			$to_user_id,
			$amount,
			$reason,
			$operation_key,
			true,
			$allow_negative
		);
	}

	private function record_atomically(int $from_user_id, int $to_user_id, int $amount,
		string $reason, string $operation_key, bool $debit, bool $allow_negative): operation
	{
		$existing = $this->find_operation($operation_key);
		if ($existing !== null)
		{
			return $this->assert_same_operation($existing, $from_user_id, $to_user_id, $amount);
		}

		$this->db->sql_transaction('begin');
		try
		{
			if (!$this->reserve_operation($operation_key))
			{
				throw new \RuntimeException('The BBPoints operation key could not be reserved.');
			}
			if ($debit)
			{
				$this->lock_users(array_filter([$from_user_id, $to_user_id]));
				$balance = $this->get_balance($from_user_id);
				if (!$allow_negative && $balance < $amount)
				{
					throw new insufficient_funds($balance, $amount);
				}
			}

			$operation = $this->insert_movement($from_user_id, $to_user_id, $amount, $reason, $operation_key);
			if ($operation === null)
			{
				throw new \RuntimeException('The BBPoints movement could not be recorded.');
			}
			$this->bind_operation($operation_key, $operation->get_id());
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			$existing = $this->find_operation($operation_key);
			if ($existing !== null)
			{
				return $this->assert_same_operation($existing, $from_user_id, $to_user_id, $amount);
			}
			throw $exception;
		}

		$this->announce($operation);
		return $operation;
	}

	private function lock_users(array $user_ids): void
	{
		$user_ids = array_values(array_unique(array_map('intval', $user_ids)));
		sort($user_ids, SORT_NUMERIC);
		foreach ($user_ids as $user_id)
		{
			$sql = 'UPDATE ' . $this->users_table . '
				SET user_id = user_id
				WHERE user_id = ' . $user_id;
			$this->db->sql_query($sql);
			$this->assert_user_exists($user_id);
		}
	}

	private function reserve_operation(string $operation_key): bool
	{
		$sql_ary = [
			'operation_key' => $operation_key,
			'movement_id'   => 0,
		];
		$sql = 'INSERT INTO ' . $this->operations_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);

		return $this->execute_write($sql);
	}

	private function insert_movement(int $from_user_id, int $to_user_id, int $amount,
		string $reason, string $operation_key): ?operation
	{
		$timestamp = time();
		$sql_ary = [
			'from_id'       => $from_user_id,
			'to_id'         => $to_user_id,
			'bbpoints'      => $amount,
			'reason'        => utf8_substr(trim($reason), 0, 255),
			'timestamp'     => $timestamp,
		];
		$sql = 'INSERT INTO ' . $this->bbpoints_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
		if (!$this->execute_write($sql))
		{
			return null;
		}

		return new operation(
			(int) $this->db->sql_nextid(),
			$from_user_id,
			$to_user_id,
			$amount,
			$sql_ary['reason'],
			$operation_key,
			$timestamp,
			true
		);
	}

	private function bind_operation(string $operation_key, int $movement_id): void
	{
		$sql = 'UPDATE ' . $this->operations_table . '
			SET movement_id = ' . $movement_id . "
			WHERE operation_key = '" . $this->db->sql_escape($operation_key) . "'";
		$this->db->sql_query($sql);
		if ((int) $this->db->sql_affectedrows() !== 1)
		{
			throw new \RuntimeException('The BBPoints operation could not be linked to its movement.');
		}
	}

	private function execute_write(string $sql): bool
	{
		$this->db->sql_return_on_error(true);
		$this->db->sql_query($sql);
		$failed = $this->db->get_sql_error_triggered();
		$this->db->sql_return_on_error(false);

		return !$failed;
	}

	private function find_operation(string $operation_key): ?operation
	{
		$sql = 'SELECT p.id, p.from_id, p.to_id, p.bbpoints, p.reason, p.timestamp, o.operation_key
			FROM ' . $this->operations_table . ' o
			JOIN ' . $this->bbpoints_table . ' p ON p.id = o.movement_id' . "
			WHERE o.operation_key = '" . $this->db->sql_escape($operation_key) . "'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$row)
		{
			return null;
		}

		return new operation(
			(int) $row['id'],
			(int) $row['from_id'],
			(int) $row['to_id'],
			(int) $row['bbpoints'],
			(string) $row['reason'],
			(string) $row['operation_key'],
			(int) $row['timestamp'],
			false
		);
	}

	private function assert_same_operation(operation $operation, int $from_user_id,
		int $to_user_id, int $amount): operation
	{
		if ($operation->get_from_user_id() !== $from_user_id
			|| $operation->get_to_user_id() !== $to_user_id
			|| $operation->get_amount() !== $amount)
		{
			throw new operation_conflict('The BBPoints operation key already belongs to another movement.');
		}

		return $operation;
	}

	private function validate_movement(int $from_user_id, int $to_user_id, int $amount,
		string $operation_key): void
	{
		$this->validate_operation_key($operation_key);
		if ($amount <= 0)
		{
			throw new invalid_operation('The BBPoints amount must be greater than zero.');
		}
		if ($from_user_id === $to_user_id)
		{
			throw new invalid_operation('A BBPoints movement requires two different accounts.');
		}
		if ($from_user_id !== self::SYSTEM_USER_ID && !$this->is_registered_user_id($from_user_id))
		{
			throw new invalid_operation('The BBPoints payer must be a registered user.');
		}
		if ($to_user_id !== self::SYSTEM_USER_ID && !$this->is_registered_user_id($to_user_id))
		{
			throw new invalid_operation('The BBPoints recipient must be a registered user.');
		}
	}

	private function validate_operation_key(string $operation_key): void
	{
		if (!preg_match(self::OPERATION_KEY_PATTERN, $operation_key))
		{
			throw new invalid_operation('The BBPoints operation key is invalid.');
		}
	}

	private function is_registered_user_id(int $user_id): bool
	{
		$anonymous = defined('ANONYMOUS') ? (int) ANONYMOUS : 1;
		return $user_id > $anonymous;
	}

	private function assert_user_exists(int $user_id): void
	{
		$sql = 'SELECT user_id
			FROM ' . $this->users_table . '
			WHERE user_id = ' . $user_id;
		$result = $this->db->sql_query($sql);
		$exists = (bool) $this->db->sql_fetchfield('user_id');
		$this->db->sql_freeresult($result);
		if (!$exists)
		{
			throw new invalid_operation('The BBPoints user account does not exist.');
		}
	}

	private function announce(operation $operation): void
	{
		$this->cache->destroy('sql', [$this->bbpoints_table, $this->operations_table]);
		$this->dispatcher->trigger_event('sitesplat.bbpoints.operation_recorded', [
			'operation' => $operation,
		]);
	}
}
