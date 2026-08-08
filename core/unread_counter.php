<?php
/**
 * phpBB Gallery unread-image counter.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core;

/**
 * Counts visible images newer than each album's effective read marker.
 */
class unread_counter
{
	private \phpbb\db\driver\driver_interface $db;
	private \phpbb\user $user;
	private \phpbbgallery\core\album_access $album_access;
	private \phpbbgallery\core\user $gallery_user;
	private \phpbbgallery\core\policy\image_visibility $image_visibility;
	private string $images_table;
	private string $tracking_table;
	private string $image_tracking_table;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\user $user,
		\phpbbgallery\core\album_access $album_access,
		\phpbbgallery\core\user $gallery_user,
		\phpbbgallery\core\policy\image_visibility $image_visibility,
		string $images_table,
		string $tracking_table,
		string $image_tracking_table
	)
	{
		$this->db = $db;
		$this->user = $user;
		$this->album_access = $album_access;
		$this->gallery_user = $gallery_user;
		$this->image_visibility = $image_visibility;
		$this->images_table = $images_table;
		$this->tracking_table = $tracking_table;
		$this->image_tracking_table = $image_tracking_table;
	}

	/**
	 * Count unread visible images, stopping at the requested display boundary.
	 */
	public function count(int $limit = 100): int
	{
		$limit = min(100, max(0, $limit));
		if ($limit === 0 || empty($this->user->data['is_registered']) || !empty($this->user->data['is_bot']))
		{
			return 0;
		}

		$access = $this->album_access->resolve();
		$visible_album_ids = $access['visible'];
		$moderated_album_ids = $access['moderated'];

		if (!$visible_album_ids)
		{
			return 0;
		}

		$viewer_id = (int) $this->gallery_user->user_id;
		$global_mark_time = max(0, (int) $this->gallery_user->get_data('user_lastmark'));
		$sql = 'SELECT i.image_id
			FROM ' . $this->images_table . ' i
			LEFT JOIN ' . $this->tracking_table . ' t
				ON t.user_id = ' . (int) $viewer_id . '
					AND t.album_id = i.image_album_id
			LEFT JOIN ' . $this->image_tracking_table . ' it
				ON it.user_id = ' . (int) $viewer_id . '
					AND it.image_id = i.image_id
			WHERE ' . $this->db->sql_in_set('i.image_album_id', $visible_album_ids) . '
				AND it.image_id IS NULL
				AND ' . $this->db->sql_in_set('i.image_status', [block::STATUS_APPROVED, block::STATUS_LOCKED]) . '
				AND ' . $this->image_visibility->get_visibility_sql_for_results('i', $moderated_album_ids) . '
				AND (
					((t.mark_time IS NULL OR t.mark_time = 0) AND i.image_time > ' . (int) $global_mark_time . ')
					OR (t.mark_time > 0 AND i.image_time > t.mark_time)
				)';
		$result = $this->db->sql_query_limit($sql, $limit);
		$count = 0;
		while ($this->db->sql_fetchrow($result))
		{
			$count++;
		}
		$this->db->sql_freeresult($result);

		return $count;
	}

	/** Record one visible image as read for the current member. */
	public function mark_viewed(int $image_id): void
	{
		$user_id = (int) ($this->user->data['user_id'] ?? ANONYMOUS);
		if ($image_id < 1 || $user_id === ANONYMOUS || !empty($this->user->data['is_bot']))
		{
			return;
		}

		$sql = 'SELECT image_id
			FROM ' . $this->image_tracking_table . '
			WHERE user_id = ' . $user_id . '
				AND image_id = ' . $image_id;
		$result = $this->db->sql_query($sql);
		$exists = $this->db->sql_fetchfield('image_id', false, $result);
		$this->db->sql_freeresult($result);
		if ($exists !== false)
		{
			return;
		}

		$sql_ary = [
			'user_id' => $user_id,
			'image_id' => $image_id,
			'mark_time' => time(),
		];
		$this->db->sql_query('INSERT INTO ' . $this->image_tracking_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));
	}

	/** Remove per-image markers after images are deleted. */
	public function remove_images(array $image_ids): void
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids))));
		if (!$image_ids)
		{
			return;
		}

		$this->db->sql_query('DELETE FROM ' . $this->image_tracking_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids));
	}
}
