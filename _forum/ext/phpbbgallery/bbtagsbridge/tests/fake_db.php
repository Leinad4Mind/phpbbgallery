<?php
/**
 * Focused BBTags Bridge database test double.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\tests;

final class fake_db implements \phpbb\db\driver\driver_interface
{
	public array $images = [];
	public array $albums = [];
	public array $catalogue = [];
	public array $relations = [];
	public array $usage = [];
	public array $facet_rows = [];
	public array $transactions = [];
	private array $pending = [];
	private array $built = [];
	private ?array $snapshot = null;

	public function sql_query_limit($sql, $total, $offset = 0, $cache_ttl = 0): string
	{
		return $this->sql_query($sql, $cache_ttl);
	}

	public function sql_query($sql, $cache_ttl = 0): string|false
	{
		$this->pending = [];
		if (preg_match('/FROM images\s+WHERE image_id = (\d+)/s', $sql, $matches))
		{
			$image_id = (int) $matches[1];
			if (isset($this->images[$image_id]))
			{
				$this->pending[] = ['image_album_id' => $this->images[$image_id]];
			}
		}
		else if (str_contains($sql, 'SELECT album_id, parent_id') && str_contains($sql, 'FROM albums'))
		{
			foreach ($this->albums as $album_id => $parent_id)
			{
				$this->pending[] = ['album_id' => $album_id, 'parent_id' => $parent_id];
			}
		}
		else if (preg_match('/FROM albums\s+WHERE album_id = (\d+)/s', $sql, $matches))
		{
			$album_id = (int) $matches[1];
			if (array_key_exists($album_id, $this->albums))
			{
				$this->pending[] = ['parent_id' => $this->albums[$album_id]];
			}
		}
		else if (str_contains($sql, 'COUNT(DISTINCT it.image_id) AS image_count'))
		{
			$this->pending = $this->facet_rows;
		}
		else if (str_contains($sql, 'FROM image_tags it') && str_contains($sql, 'INNER JOIN bbtags b'))
		{
			preg_match('/WHERE it\.image_id = (\d+)/', $sql, $matches);
			$image_id = (int) ($matches[1] ?? 0);
			foreach ($this->relations as $relation)
			{
				if ($relation['image_id'] === $image_id && isset($this->catalogue[$relation['tag_id']]))
				{
					$tag = $this->catalogue[$relation['tag_id']];
					$this->pending[] = [
						'id' => $relation['tag_id'],
						'tag' => $tag,
						'tag_clean' => mb_strtolower($tag, 'UTF-8'),
						'usage_count' => $this->usage[$relation['tag_id']] ?? 0,
					];
				}
			}
			usort($this->pending, static function (array $left, array $right): int
			{
				return $left['tag_clean'] <=> $right['tag_clean'];
			});
		}
		else if (preg_match('/FROM image_tags\s+WHERE image_id = (\d+)\s+AND tag_id = (\d+)/s', $sql, $matches))
		{
			foreach ($this->relations as $relation)
			{
				if ($relation['image_id'] === (int) $matches[1] && $relation['tag_id'] === (int) $matches[2])
				{
					$this->pending[] = ['image_id' => $relation['image_id']];
				}
			}
		}
		else if (str_starts_with($sql, 'INSERT INTO image_tags'))
		{
			$this->relations[] = [
				'image_id' => (int) $this->built['image_id'],
				'tag_id' => (int) $this->built['tag_id'],
			];
		}
		else if (str_contains($sql, 'SELECT tag_id') && str_contains($sql, 'WHERE image_id ='))
		{
			preg_match('/WHERE image_id = (\d+)/', $sql, $matches);
			foreach ($this->relations as $relation)
			{
				if ($relation['image_id'] === (int) ($matches[1] ?? 0))
				{
					$this->pending[] = ['tag_id' => $relation['tag_id']];
				}
			}
			usort($this->pending, static function (array $left, array $right): int
			{
				return $left['tag_id'] <=> $right['tag_id'];
			});
		}
		else if (str_contains($sql, 'SELECT DISTINCT tag_id'))
		{
			$image_ids = $this->integer_values($sql);
			$tags = [];
			foreach ($this->relations as $relation)
			{
				if (in_array($relation['image_id'], $image_ids, true))
				{
					$tags[$relation['tag_id']] = ['tag_id' => $relation['tag_id']];
				}
			}
			$this->pending = array_values($tags);
		}
		else if (str_starts_with($sql, 'DELETE FROM image_tags'))
		{
			$image_ids = $this->integer_values($sql);
			$this->relations = array_values(array_filter($this->relations, static function (array $relation) use ($image_ids): bool
			{
				return !in_array($relation['image_id'], $image_ids, true);
			}));
		}
		else if (str_contains($sql, 'COUNT(image_id) AS usage_count'))
		{
			$tag_ids = $this->integer_values($sql);
			$counts = [];
			foreach ($this->relations as $relation)
			{
				if (in_array($relation['tag_id'], $tag_ids, true))
				{
					$counts[$relation['tag_id']] = ($counts[$relation['tag_id']] ?? 0) + 1;
				}
			}
			foreach ($counts as $tag_id => $count)
			{
				$this->pending[] = ['tag_id' => $tag_id, 'usage_count' => $count];
			}
		}
		else if (preg_match('/UPDATE bbtags_context[\s\S]+WHERE tag_id = (\d+)/', $sql, $matches))
		{
			$this->usage[(int) $matches[1]] = (int) $this->built['usage_count'];
		}

		return 'result';
	}

	public function sql_multi_insert($table, $sql_ary): bool
	{
		foreach ((array) $sql_ary as $row)
		{
			$this->relations[] = [
				'image_id' => (int) $row['image_id'],
				'tag_id' => (int) $row['tag_id'],
			];
		}

		return true;
	}

	public function sql_fetchrow($result = false): array|false
	{
		return array_shift($this->pending) ?? false;
	}

	public function sql_freeresult($result = false): bool
	{
		$this->pending = [];

		return true;
	}

	public function sql_build_array($query, $assoc_ary = false): string
	{
		$this->built = (array) $assoc_ary;

		return strtoupper((string) $query) . '_VALUES';
	}

	public function sql_in_set($field, $array, $negate = false, $allow_empty_set = false): string
	{
		return $field . ' IN (' . implode(',', array_map('intval', (array) $array)) . ')';
	}

	public function sql_escape($message): string
	{
		return str_replace("'", "''", (string) $message);
	}

	public function sql_transaction($status = 'begin'): bool
	{
		$this->transactions[] = $status;
		if ($status === 'begin')
		{
			$this->snapshot = [$this->relations, $this->usage];
		}
		else if ($status === 'rollback' && $this->snapshot !== null)
		{
			[$this->relations, $this->usage] = $this->snapshot;
			$this->snapshot = null;
		}
		else if ($status === 'commit')
		{
			$this->snapshot = null;
		}

		return true;
	}

	private function integer_values(string $sql): array
	{
		preg_match('/IN \(([^)]*)\)/', $sql, $matches);

		return array_values(array_filter(array_map('intval', explode(',', $matches[1] ?? ''))));
	}
}
