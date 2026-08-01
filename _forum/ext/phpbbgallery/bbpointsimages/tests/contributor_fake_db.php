<?php
/**
 * BBPoints Images contributor database test double
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

final class contributor_fake_db implements \phpbb\db\driver\driver_interface
{
	public array $users = [];
	public array $contributors = [];
	private array $pending = [];

	public function sql_in_set(string $field, array $values): string
	{
		$values = array_map(static function (mixed $value): string
		{
			return is_int($value) ? (string) $value : "'" . str_replace("'", "''", (string) $value) . "'";
		}, $values);

		return $field . ' IN (' . implode(', ', $values) . ')';
	}

	public function sql_query(string $sql): string
	{
		$this->pending = [];
		if (str_contains($sql, 'FROM users'))
		{
			preg_match_all("/'((?:''|[^'])*)'/", $sql, $matches);
			$wanted = array_map(static fn (string $value): string => str_replace("''", "'", $value), $matches[1]);
			foreach ($this->users as $user)
			{
				if (in_array($user['username_clean'], $wanted, true) && in_array($user['user_type'], [0, 3], true))
				{
					$this->pending[] = $user;
				}
			}
		}
		else if (str_contains($sql, 'FROM contributors c'))
		{
			preg_match('/c\.image_id = (\d+)/', $sql, $matches);
			$image_id = (int) ($matches[1] ?? 0);
			$rows = $this->contributors[$image_id] ?? [];
			usort($rows, static fn (array $left, array $right): int => [$left['contributor_order'], $left['user_id']] <=> [$right['contributor_order'], $right['user_id']]);
			foreach ($rows as $relation)
			{
				$user = $this->users[$relation['user_id']] ?? null;
				if ($user && in_array($user['user_type'], [0, 3], true))
				{
					$this->pending[] = array_merge($relation, $user);
				}
			}
		}
		else if (str_starts_with($sql, 'DELETE FROM contributors'))
		{
			preg_match('/image_id IN \(([^)]+)\)/', $sql, $matches);
			$image_ids = array_map('intval', explode(',', $matches[1] ?? ''));
			preg_match('/AND user_id = (\d+)/', $sql, $user_match);
			$author_id = isset($user_match[1]) ? (int) $user_match[1] : 0;
			foreach ($image_ids as $image_id)
			{
				if ($author_id === 0)
				{
					unset($this->contributors[$image_id]);
					continue;
				}
				$this->contributors[$image_id] = array_values(array_filter(
					$this->contributors[$image_id] ?? [],
					static fn (array $row): bool => $row['user_id'] !== $author_id
				));
			}
		}

		return 'result';
	}

	public function sql_multi_insert(string $table, array $rows): void
	{
		foreach ($rows as $row)
		{
			$this->contributors[$row['image_id']][] = $row;
		}
	}

	public function sql_fetchrow(string $result): array|false
	{
		return array_shift($this->pending) ?? false;
	}

	public function sql_freeresult(string $result): void
	{
		$this->pending = [];
	}
}
