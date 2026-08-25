<?php
/**
 * phpBB Gallery - Featured Images manager.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\featured;

class manager
{
	public function __construct(
		protected \phpbb\db\driver\driver_interface $db,
		protected string $featured_table,
		protected string $images_table
	)
	{
	}

	public function is_featured(int $image_id): bool
	{
		return in_array($image_id, $this->get_featured_ids([$image_id]), true);
	}

	public function feature(int $image_id, int $user_id, ?int $time = null): bool
	{
		if ($image_id <= 0 || $user_id <= 0 || $this->is_featured($image_id))
		{
			return false;
		}
		$this->db->sql_query('INSERT INTO ' . $this->featured_table . ' ' . $this->db->sql_build_array('INSERT', [
			'image_id' => $image_id,
			'featured_by' => $user_id,
			'featured_time' => $time ?? time(),
		]));
		return true;
	}

	public function unfeature(int $image_id): bool
	{
		if ($image_id <= 0)
		{
			return false;
		}
		$this->db->sql_query('DELETE FROM ' . $this->featured_table . '
			WHERE image_id = ' . $image_id);
		return $this->db->sql_affectedrows() > 0;
	}

	public function get_image_ids(int $limit = 50): array
	{
		$limit = max(0, min(500, $limit));
		if ($limit === 0)
		{
			return [];
		}
		$ids = [];
		$result = $this->db->sql_query_limit('SELECT image_id
			FROM ' . $this->featured_table . '
			ORDER BY featured_time DESC, image_id DESC', $limit);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);
		return $ids;
	}

	public function get_featured_ids(array $image_ids): array
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids))));
		if (!$image_ids)
		{
			return [];
		}
		$ids = [];
		$result = $this->db->sql_query('SELECT image_id
			FROM ' . $this->featured_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids));
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);
		return $ids;
	}

	public function delete_images(array|int $image_ids): void
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', (array) $image_ids))));
		if ($image_ids)
		{
			$this->db->sql_query('DELETE FROM ' . $this->featured_table . '
				WHERE ' . $this->db->sql_in_set('image_id', $image_ids));
		}
	}

	public function reconcile_orphans(): int
	{
		$sql = 'DELETE FROM ' . $this->featured_table . '
			WHERE image_id NOT IN (
				SELECT image_id FROM ' . $this->images_table . '
			)';
		$this->db->sql_query($sql);
		return $this->db->sql_affectedrows();
	}
}
