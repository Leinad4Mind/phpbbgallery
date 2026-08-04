<?php
/**
 * phpBB Gallery - Image Revisions database test double
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\tests;

final class fake_db implements \phpbb\db\driver\driver_interface
{
	public array $images;
	public array $revisions = [];
	public array $transactions = [];
	public array $statements = [];
	public array $rows = [];
	public array $inserted = [];
	public string $last_query = '';
	public bool $reject_updates = false;
	private array $pending = [];
	private array $built = [];
	private int $next_revision_id = 1;
	private int $affected_rows = 0;
	private ?array $snapshot = null;

	public function __construct(array $images = [])
	{
		$this->images = $images;
	}

	public function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		return $field . ($negate ? ' NOT IN (' : ' IN (') . implode(',', (array) $array) . ')';
	}

	public function sql_build_array($query, $assoc_ary = false)
	{
		$this->built = (array) $assoc_ary;

		return strtoupper((string) $query) === 'INSERT' ? 'VALUES (test)' : 'test = values';
	}

	public function sql_query($sql, $cache_ttl = 0)
	{
		$this->statements[] = $sql;
		$this->last_query = $sql;
		$this->pending = [];
		$this->affected_rows = 0;

		if (str_contains($sql, 'FROM albums ') || str_contains($sql, 'FROM rules rules'))
		{
			$this->pending = $this->rows;
		}
		else if (preg_match('/INSERT INTO rules/', $sql))
		{
			$this->inserted[] = $this->built;
			$this->affected_rows = 1;
		}
		else if (str_contains($sql, 'LEFT JOIN images image'))
		{
			foreach ($this->revisions as $revision)
			{
				$image_id = (int) $revision['image_id'];
				if (!isset($this->images[$image_id]))
				{
					$this->pending[$image_id] = ['image_id' => $image_id];
				}
			}
			$this->pending = array_values($this->pending);
		}
		else if (preg_match('/SELECT \*\s+FROM images\s+WHERE image_id IN \(([^)]*)\)/s', $sql, $matches))
		{
			foreach ($this->ids($matches[1]) as $image_id)
			{
				if (isset($this->images[$image_id]))
				{
					$this->pending[] = $this->images[$image_id];
				}
			}
		}
		else if (preg_match('/SELECT \*\s+FROM revisions\s+WHERE revision_id = (\d+)\s+AND image_id = (\d+)/s', $sql, $matches))
		{
			$revision_id = (int) $matches[1];
			if (isset($this->revisions[$revision_id]) && (int) $this->revisions[$revision_id]['image_id'] === (int) $matches[2])
			{
				$this->pending[] = $this->revisions[$revision_id];
			}
		}
		else if (preg_match('/SELECT r\.\*, u\.username, u\.user_colour[\s\S]+WHERE r\.image_id = (\d+)/', $sql, $matches))
		{
			$this->pending = $this->for_image((int) $matches[1], true);
		}
		else if (preg_match('/SELECT revision_id, revision_filename\s+FROM revisions\s+WHERE image_id = (\d+)/s', $sql, $matches))
		{
			$this->pending = $this->for_image((int) $matches[1]);
		}
		else if (preg_match('/SELECT revision_filename\s+FROM revisions\s+WHERE image_id IN \(([^)]*)\)/s', $sql, $matches))
		{
			$image_ids = $this->ids($matches[1]);
			foreach ($this->revisions as $revision)
			{
				if (in_array((int) $revision['image_id'], $image_ids, true))
				{
					$this->pending[] = ['revision_filename' => $revision['revision_filename']];
				}
			}
		}
		else if (preg_match('/INSERT INTO revisions/', $sql))
		{
			$revision_id = $this->next_revision_id++;
			$this->revisions[$revision_id] = ['revision_id' => $revision_id] + $this->built;
			$this->affected_rows = 1;
		}
		else if (preg_match('/UPDATE images[\s\S]+WHERE image_id = (\d+)/', $sql, $matches))
		{
			$image_id = (int) $matches[1];
			if (!$this->reject_updates && isset($this->images[$image_id]))
			{
				$this->images[$image_id] = array_merge($this->images[$image_id], $this->built);
				$this->affected_rows = 1;
			}
		}
		else if (preg_match('/DELETE FROM images\s+WHERE image_id = (\d+)/s', $sql, $matches))
		{
			unset($this->images[(int) $matches[1]]);
			$this->affected_rows = 1;
		}
		else if (preg_match('/DELETE FROM revisions\s+WHERE revision_id = (\d+)\s+AND image_id = (\d+)/s', $sql, $matches))
		{
			$revision_id = (int) $matches[1];
			if (isset($this->revisions[$revision_id]) && (int) $this->revisions[$revision_id]['image_id'] === (int) $matches[2])
			{
				unset($this->revisions[$revision_id]);
			}
		}
		else if (preg_match('/DELETE FROM revisions\s+WHERE revision_id IN \(([^)]*)\)/s', $sql, $matches))
		{
			foreach ($this->ids($matches[1]) as $revision_id)
			{
				unset($this->revisions[$revision_id]);
			}
		}
		else if (preg_match('/DELETE FROM revisions\s+WHERE image_id IN \(([^)]*)\)/s', $sql, $matches))
		{
			$image_ids = $this->ids($matches[1]);
			$this->revisions = array_filter($this->revisions, static fn (array $revision): bool => !in_array((int) $revision['image_id'], $image_ids, true));
		}

		return 'handle';
	}

	public function sql_query_limit($sql, $total, $offset = 0, $cache_ttl = 0)
	{
		return $this->sql_query($sql, $cache_ttl);
	}

	public function sql_fetchrow($handle = false)
	{
		return array_shift($this->pending) ?? false;
	}

	public function sql_freeresult($handle = false)
	{
		$this->pending = [];

		return true;
	}

	public function sql_transaction($status = 'begin')
	{
		$this->transactions[] = $status;
		if ($status === 'begin')
		{
			$this->snapshot = [$this->images, $this->revisions, $this->next_revision_id];
		}
		else if ($status === 'rollback' && $this->snapshot !== null)
		{
			[$this->images, $this->revisions, $this->next_revision_id] = $this->snapshot;
			$this->snapshot = null;
		}
		else if ($status === 'commit')
		{
			$this->snapshot = null;
		}

		return true;
	}

	public function sql_affectedrows(): int
	{
		return $this->affected_rows;
	}

	public function sql_escape($message): string
	{
		return str_replace("'", "''", (string) $message);
	}

	private function ids(string $list): array
	{
		return array_map('intval', array_filter(explode(',', $list), 'strlen'));
	}

	private function for_image(int $image_id, bool $with_user = false): array
	{
		$rows = array_values(array_filter($this->revisions, static fn (array $revision): bool => (int) $revision['image_id'] === $image_id));
		usort($rows, static fn (array $left, array $right): int => [(int) $right['revision_time'], (int) $right['revision_id']] <=> [(int) $left['revision_time'], (int) $left['revision_id']]);
		if ($with_user)
		{
			$rows = array_map(static fn (array $revision): array => $revision + ['username' => 'Editor', 'user_colour' => ''], $rows);
		}

		return $rows;
	}
}
