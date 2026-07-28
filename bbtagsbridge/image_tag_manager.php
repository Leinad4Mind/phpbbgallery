<?php
/**
 * Stores Gallery image relations to the shared BBTags catalogue.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge;

use phpbb\db\driver\driver_interface;

final class image_tag_manager
{
	public const PROVIDER = 'gallery_images';

	private driver_interface $db;
	private string $image_tags_table;
	private string $images_table;
	private string $bbtags_table;
	private string $bbtags_context_table;

	public function __construct(
		driver_interface $db,
		string $image_tags_table,
		string $images_table,
		string $bbtags_table,
		string $bbtags_context_table
	)
	{
		$this->db = $db;
		$this->image_tags_table = $image_tags_table;
		$this->images_table = $images_table;
		$this->bbtags_table = $bbtags_table;
		$this->bbtags_context_table = $bbtags_context_table;
	}

	public function image_matches_album(int $image_id, int $album_id): bool
	{
		if ($image_id <= 0 || $album_id <= 0)
		{
			return false;
		}
		$sql = 'SELECT image_album_id
			FROM ' . $this->images_table . '
			WHERE image_id = ' . $image_id;
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row && (int) $row['image_album_id'] === $album_id;
	}

	public function attach_tag(int $image_id, int $tag_id): bool
	{
		if ($image_id <= 0 || $tag_id <= 0)
		{
			return false;
		}
		$sql = 'SELECT image_id
			FROM ' . $this->image_tags_table . '
			WHERE image_id = ' . $image_id . '
				AND tag_id = ' . $tag_id;
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$row)
		{
			$sql_ary = ['image_id' => $image_id, 'tag_id' => $tag_id];
			$sql = 'INSERT INTO ' . $this->image_tags_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			if ($this->db->sql_query($sql) === false)
			{
				return false;
			}
		}

		return $this->sync_usage([$tag_id]);
	}

	/**
	 * @return int[]
	 */
	public function get_tag_ids_for_image(int $image_id): array
	{
		if ($image_id <= 0)
		{
			return [];
		}
		$sql = 'SELECT tag_id
			FROM ' . $this->image_tags_table . '
			WHERE image_id = ' . $image_id . '
			ORDER BY tag_id ASC';
		$result = $this->db->sql_query($sql);
		$tag_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag_ids[] = (int) $row['tag_id'];
		}
		$this->db->sql_freeresult($result);

		return $tag_ids;
	}

	/**
	 * @return array<int, array{id: int, tag: string, tag_clean: string, usage_count: int}>
	 */
	public function get_tags_for_image(int $image_id): array
	{
		if ($image_id <= 0)
		{
			return [];
		}
		$sql = 'SELECT b.id, b.tag, b.tag_clean, c.usage_count
			FROM ' . $this->image_tags_table . ' it
			INNER JOIN ' . $this->bbtags_table . ' b
				ON b.id = it.tag_id
			LEFT JOIN ' . $this->bbtags_context_table . " c
				ON c.tag_id = b.id AND c.provider = '" . self::PROVIDER . "'
			WHERE it.image_id = " . $image_id . '
			ORDER BY b.tag_clean ASC';
		$result = $this->db->sql_query($sql);
		$tags = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tags[] = [
				'id' => (int) $row['id'],
				'tag' => (string) $row['tag'],
				'tag_clean' => (string) $row['tag_clean'],
				'usage_count' => (int) ($row['usage_count'] ?? 0),
			];
		}
		$this->db->sql_freeresult($result);

		return $tags;
	}

	/**
	 * Return tag counts per album inside a permission-filtered Core search.
	 *
	 * @return array<int, array{tag_id: int, tag: string, tag_clean: string, album_id: int, image_count: int}>
	 */
	public function get_facet_rows(string $image_where): array
	{
		if (trim($image_where) === '')
		{
			return [];
		}
		$sql = 'SELECT it.tag_id, b.tag, b.tag_clean, i.image_album_id,
				COUNT(DISTINCT it.image_id) AS image_count
			FROM ' . $this->image_tags_table . ' it
			INNER JOIN ' . $this->images_table . ' i
				ON i.image_id = it.image_id
			INNER JOIN ' . $this->bbtags_table . ' b
				ON b.id = it.tag_id
			WHERE (' . $image_where . ')
			GROUP BY it.tag_id, b.tag, b.tag_clean, i.image_album_id
			ORDER BY b.tag_clean ASC';
		$result = $this->db->sql_query($sql);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = [
				'tag_id' => (int) $row['tag_id'],
				'tag' => (string) $row['tag'],
				'tag_clean' => (string) $row['tag_clean'],
				'album_id' => (int) $row['image_album_id'],
				'image_count' => (int) $row['image_count'],
			];
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}

	public function replace_tags(int $image_id, array $tag_ids): bool
	{
		if ($image_id <= 0)
		{
			return false;
		}
		$tag_ids = array_values(array_unique(array_filter(array_map('intval', $tag_ids))));
		$old_tag_ids = $this->get_tag_ids_for_image($image_id);
		$affected_tag_ids = array_values(array_unique(array_merge($old_tag_ids, $tag_ids)));

		$this->db->sql_transaction('begin');
		$sql = 'DELETE FROM ' . $this->image_tags_table . '
			WHERE ' . $this->db->sql_in_set('image_id', [$image_id]);
		if ($this->db->sql_query($sql) === false)
		{
			$this->db->sql_transaction('rollback');
			return false;
		}
		if (!empty($tag_ids))
		{
			$rows = array_map(static function (int $tag_id) use ($image_id): array
			{
				return ['image_id' => $image_id, 'tag_id' => $tag_id];
			}, $tag_ids);
			if ($this->db->sql_multi_insert($this->image_tags_table, $rows) === false)
			{
				$this->db->sql_transaction('rollback');
				return false;
			}
		}
		if (!$this->sync_usage($affected_tag_ids))
		{
			$this->db->sql_transaction('rollback');
			return false;
		}
		$this->db->sql_transaction('commit');

		return true;
	}

	public function delete_for_images(array $image_ids): bool
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids), static function (int $image_id): bool
		{
			return $image_id > 0;
		})));
		if (empty($image_ids))
		{
			return true;
		}

		$sql = 'SELECT DISTINCT tag_id
			FROM ' . $this->image_tags_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		$tag_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag_ids[] = (int) $row['tag_id'];
		}
		$this->db->sql_freeresult($result);

		$this->db->sql_transaction('begin');
		$sql = 'DELETE FROM ' . $this->image_tags_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		if ($this->db->sql_query($sql) === false || !$this->sync_usage($tag_ids))
		{
			$this->db->sql_transaction('rollback');
			return false;
		}
		$this->db->sql_transaction('commit');

		return true;
	}

	private function sync_usage(array $tag_ids): bool
	{
		$tag_ids = array_values(array_unique(array_filter(array_map('intval', $tag_ids))));
		if (empty($tag_ids))
		{
			return true;
		}

		$sql = 'SELECT tag_id, COUNT(image_id) AS usage_count
			FROM ' . $this->image_tags_table . '
			WHERE ' . $this->db->sql_in_set('tag_id', $tag_ids) . '
			GROUP BY tag_id';
		$result = $this->db->sql_query($sql);
		$usage = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$usage[(int) $row['tag_id']] = (int) $row['usage_count'];
		}
		$this->db->sql_freeresult($result);

		foreach ($tag_ids as $tag_id)
		{
			$sql_ary = ['usage_count' => $usage[$tag_id] ?? 0];
			$sql = 'UPDATE ' . $this->bbtags_context_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE tag_id = ' . $tag_id . "
					AND provider = '" . self::PROVIDER . "'";
			if ($this->db->sql_query($sql) === false)
			{
				return false;
			}
		}

		return true;
	}
}
