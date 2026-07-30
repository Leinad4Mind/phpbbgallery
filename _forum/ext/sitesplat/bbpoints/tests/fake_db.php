<?php
/**
 * BBPoints in-memory database test double.
 *
 * @package sitesplat/bbpoints
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbpoints\tests;

final class fake_db implements \phpbb\db\driver\driver_interface
{
	public array $users;
	public array $posts;
	public array $topics;
	public array $movements;
	public array $operations = [];
	public array $statements = [];
	public array $transactions = [];
	public bool $fail_next_insert = false;
	private array $built = [];
	private array $pending = [];
	private int $next_id = 1;
	private bool $error = false;
	private int $affected_rows = 0;
	private ?array $snapshot = null;

	public function __construct(array $users = [], array $posts = [], array $topics = [], array $movements = [])
	{
		$this->users = array_fill_keys(array_map('intval', $users), true);
		$this->posts = $posts;
		$this->topics = $topics;
		$this->movements = [];
		foreach ($movements as $movement)
		{
			$id = (int) ($movement['id'] ?? $this->next_id);
			$this->movements[$id] = ['id' => $id] + $movement;
			$this->next_id = max($this->next_id, $id + 1);
		}
	}

	public function sql_query($sql, $cache_ttl = 0)
	{
		$this->statements[] = $sql;
		$this->pending = [];
		$this->affected_rows = 0;

		if (str_contains($sql, ' AS total'))
		{
			preg_match('/poster_id = (\d+)/', $sql, $matches);
			$user_id = (int) ($matches[1] ?? 0);
			$total = 0;
			foreach ($this->posts as $post)
			{
				if ((int) $post['poster_id'] === $user_id && (int) $post['post_visibility'] === ITEM_APPROVED)
				{
					$total += (int) $post['bbpoints'];
				}
			}
			foreach ($this->topics as $topic)
			{
				if ((int) $topic['topic_poster'] === $user_id)
				{
					$total += (int) $topic['bbpoints'];
				}
			}
			foreach ($this->movements as $movement)
			{
				$total += (int) $movement['to_id'] === $user_id ? (int) $movement['bbpoints'] : 0;
				$total -= (int) $movement['from_id'] === $user_id ? (int) $movement['bbpoints'] : 0;
			}
			$this->pending[] = ['total' => $total];
		}
		else if (preg_match('/SELECT user_id\s+FROM users\s+WHERE user_id = (\d+)/s', $sql, $matches))
		{
			$user_id = (int) $matches[1];
			if (isset($this->users[$user_id]))
			{
				$this->pending[] = ['user_id' => $user_id];
			}
		}
		else if (str_starts_with($sql, 'UPDATE point_operations'))
		{
			preg_match('/SET movement_id = (\d+)/', $sql, $movement_matches);
			preg_match("/WHERE operation_key = '((?:''|[^'])*)'/", $sql, $key_matches);
			$operation_key = str_replace("''", "'", $key_matches[1] ?? '');
			if (isset($this->operations[$operation_key]))
			{
				$this->operations[$operation_key]['movement_id'] = (int) ($movement_matches[1] ?? 0);
				$this->affected_rows = 1;
			}
		}
		else if (str_starts_with($sql, 'INSERT INTO point_operations'))
		{
			$operation_key = $this->built['operation_key'] ?? null;
			if ($this->fail_next_insert || isset($this->operations[$operation_key]))
			{
				$this->fail_next_insert = false;
				$this->error = true;
				return false;
			}
			$this->operations[$operation_key] = $this->built;
			$this->affected_rows = 1;
		}
		else if (str_starts_with($sql, 'INSERT INTO points'))
		{
			if ($this->fail_next_insert)
			{
				$this->fail_next_insert = false;
				$this->error = true;
				return false;
			}
			$id = $this->next_id++;
			$this->movements[$id] = ['id' => $id] + $this->built;
			$this->affected_rows = 1;
		}
		else if (preg_match("/WHERE o\.operation_key = '((?:''|[^'])*)'/", $sql, $matches))
		{
			$operation_key = str_replace("''", "'", $matches[1]);
			$movement_id = (int) ($this->operations[$operation_key]['movement_id'] ?? 0);
			if (isset($this->movements[$movement_id]))
			{
				$this->pending[] = $this->movements[$movement_id] + ['operation_key' => $operation_key];
			}
		}

		return 'handle';
	}

	public function sql_build_array($query, $assoc_ary = false): string
	{
		$this->built = (array) $assoc_ary;
		return 'VALUES (test)';
	}

	public function sql_fetchrow($query_id = false)
	{
		return array_shift($this->pending) ?? false;
	}

	public function sql_fetchfield($field, $rownum = false, $query_id = false)
	{
		$row = $this->pending[0] ?? [];
		return $row[$field] ?? false;
	}

	public function sql_freeresult($query_id = false): bool
	{
		$this->pending = [];
		return true;
	}

	public function sql_nextid(): int
	{
		return $this->next_id - 1;
	}

	public function sql_affectedrows(): int
	{
		return $this->affected_rows;
	}

	public function sql_escape($message): string
	{
		return str_replace("'", "''", (string) $message);
	}

	public function sql_return_on_error($fail = false): void
	{
		$this->error = false;
	}

	public function get_sql_error_triggered(): bool
	{
		return $this->error;
	}

	public function sql_transaction($status = 'begin'): bool
	{
		$this->transactions[] = $status;
		if ($status === 'begin')
		{
			$this->snapshot = [$this->movements, $this->operations, $this->next_id];
		}
		else if ($status === 'rollback' && $this->snapshot !== null)
		{
			[$this->movements, $this->operations, $this->next_id] = $this->snapshot;
			$this->snapshot = null;
		}
		else if ($status === 'commit')
		{
			$this->snapshot = null;
		}

		return true;
	}
}
