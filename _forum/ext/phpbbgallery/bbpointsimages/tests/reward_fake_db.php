<?php
/**
 * BBPoints Images reward database test double
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

final class reward_fake_db implements \phpbb\db\driver\driver_interface
{
	public array $policy_rows = [];
	public array $rewards = [];
	public array $stats = [];
	private array $built = [];
	private array $pending = [];
	private int $affected = 0;
	private bool $error = false;

	public function sql_query(string $sql): string|false
	{
		$this->pending = [];
		$this->affected = 0;
		if (str_contains($sql, ' current_album'))
		{
			$this->pending = $this->policy_rows;
		}
		else if (preg_match('/FROM rewards\s+WHERE image_id = (\d+)/s', $sql, $matches))
		{
			$row = $this->rewards[(int) $matches[1]] ?? null;
			$this->pending = $row ? [$row] : [];
		}
		else if (preg_match("/FROM rewards\\s+WHERE source_sha256 = '([a-f0-9]{64})'/s", $sql, $matches))
		{
			foreach ($this->rewards as $row)
			{
				if ($row['source_sha256'] === $matches[1])
				{
					$this->pending[] = $row;
					break;
				}
			}
		}
		else if (str_contains($sql, 'FROM rewards') && preg_match('/image_id IN \(([^)]+)\)/', $sql, $matches))
		{
			foreach (array_map('intval', explode(',', $matches[1])) as $image_id)
			{
				if (isset($this->rewards[$image_id]))
				{
					$this->pending[] = $this->rewards[$image_id];
				}
			}
		}
		else if (str_starts_with($sql, 'UPDATE stats'))
		{
			preg_match('/image_id = (\d+)/', $sql, $matches);
			$image_id = (int) ($matches[1] ?? 0);
			if (isset($this->stats[$image_id]))
			{
				preg_match("/source_sha256 = '([a-f0-9]{64})'/", $sql, $hash);
				$this->stats[$image_id]['source_sha256'] = $hash[1];
				$this->affected = 1;
			}
		}
		else if (str_starts_with($sql, 'UPDATE rewards'))
		{
			preg_match('/SET user_id = (\d+), reassignment_count = (\d+)/', $sql, $values);
			preg_match('/WHERE image_id = (\d+)\s+AND user_id = (\d+)\s+AND reassignment_count = (\d+)/s', $sql, $where);
			$image_id = (int) ($where[1] ?? 0);
			if (isset($this->rewards[$image_id])
				&& (int) $this->rewards[$image_id]['user_id'] === (int) ($where[2] ?? 0)
				&& (int) $this->rewards[$image_id]['reassignment_count'] === (int) ($where[3] ?? -1))
			{
				$this->rewards[$image_id]['user_id'] = (int) $values[1];
				$this->rewards[$image_id]['reassignment_count'] = (int) $values[2];
				$this->affected = 1;
			}
		}
		else if (str_starts_with($sql, 'INSERT INTO stats'))
		{
			$image_id = (int) $this->built['image_id'];
			if (isset($this->stats[$image_id]))
			{
				$this->error = true;
				return false;
			}
			$this->stats[$image_id] = $this->built;
			$this->affected = 1;
		}
		else if (str_starts_with($sql, 'INSERT INTO rewards'))
		{
			foreach ($this->rewards as $row)
			{
				if ($row['source_sha256'] === $this->built['source_sha256'])
				{
					$this->error = true;
					return false;
				}
			}
			$image_id = (int) $this->built['image_id'];
			$this->rewards[$image_id] = $this->built;
			$this->affected = 1;
		}

		return 'result';
	}

	public function sql_build_array(string $query, array $data): string
	{
		$this->built = $data;
		return 'VALUES (test)';
	}

	public function sql_in_set(string $field, array $values): string
	{
		return $field . ' IN (' . implode(',', array_map('intval', $values)) . ')';
	}

	public function sql_fetchrow(string $result): array|false
	{
		return array_shift($this->pending) ?? false;
	}

	public function sql_freeresult(string $result): void
	{
		$this->pending = [];
	}

	public function sql_affectedrows(): int
	{
		return $this->affected;
	}

	public function sql_escape(string $value): string
	{
		return str_replace("'", "''", $value);
	}

	public function sql_return_on_error(bool $enabled): void
	{
		if ($enabled)
		{
			$this->error = false;
		}
	}

	public function get_sql_error_triggered(): bool
	{
		return $this->error;
	}
}
