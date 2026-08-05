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
	private \phpbbgallery\core\auth\auth $gallery_auth;
	private \phpbbgallery\core\user $gallery_user;
	private \phpbbgallery\core\policy\image_visibility $image_visibility;
	private string $images_table;
	private string $tracking_table;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\user $user,
		\phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\user $gallery_user,
		\phpbbgallery\core\policy\image_visibility $image_visibility,
		string $images_table,
		string $tracking_table
	)
	{
		$this->db = $db;
		$this->user = $user;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_user = $gallery_user;
		$this->image_visibility = $image_visibility;
		$this->images_table = $images_table;
		$this->tracking_table = $tracking_table;
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

		$viewer_id = (int) $this->user->data['user_id'];
		$this->gallery_auth->load_user_permissions($viewer_id);

		$excluded_album_ids = $this->gallery_auth->get_exclude_zebra();
		$viewable_album_ids = array_diff($this->gallery_auth->acl_album_ids('i_view'), $excluded_album_ids);
		$moderated_album_ids = array_diff($this->gallery_auth->acl_album_ids('m_status'), $excluded_album_ids);
		$visible_album_ids = array_values(array_unique(array_map(
			'intval',
			array_merge($viewable_album_ids, $moderated_album_ids)
		)));

		if (!$visible_album_ids)
		{
			return 0;
		}

		$global_mark_time = max(0, (int) $this->gallery_user->get_data('user_lastmark'));
		$sql = 'SELECT i.image_id
			FROM ' . $this->images_table . ' i
			LEFT JOIN ' . $this->tracking_table . ' t
				ON t.user_id = ' . (int) $viewer_id . '
					AND t.album_id = i.image_album_id
			WHERE ' . $this->db->sql_in_set('i.image_album_id', $visible_album_ids) . '
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
}
