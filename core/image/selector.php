<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

/**
 * Permission-filtered image source for phpBB message editors.
 */
class selector
{
	public const PER_PAGE = 12;

	/** @var \phpbb\db\driver\driver_interface Database object */
	protected \phpbb\db\driver\driver_interface $db;

	/** @var \phpbbgallery\core\auth\auth Gallery auth object */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\policy\image_visibility Optional-feature visibility boundary */
	protected \phpbbgallery\core\policy\image_visibility $image_visibility;

	/** @var string Gallery images table */
	protected string $images_table;

	/** @var string Gallery albums table */
	protected string $albums_table;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\policy\image_visibility $image_visibility,
		string $images_table,
		string $albums_table
	)
	{
		$this->db = $db;
		$this->gallery_auth = $gallery_auth;
		$this->image_visibility = $image_visibility;
		$this->images_table = $images_table;
		$this->albums_table = $albums_table;
	}

	/**
	 * Check whether the active user owns at least one selectable image.
	 */
	public function has_images(int $user_id): bool
	{
		$viewable_album_ids = $this->get_viewable_album_ids($user_id);
		if (empty($viewable_album_ids))
		{
			return false;
		}

		$sql = 'SELECT i.image_id
			FROM ' . $this->images_table . ' i
			INNER JOIN ' . $this->albums_table . ' a
				ON a.album_id = i.image_album_id
			WHERE ' . implode(' AND ', $this->get_image_conditions($user_id, $viewable_album_ids));
		$result = $this->db->sql_query_limit($sql, 1);
		$has_images = (bool) $this->db->sql_fetchfield('image_id');
		$this->db->sql_freeresult($result);

		return $has_images;
	}

	/**
	 * Return one page of completed images authored by the active user.
	 *
	 * Unapproved, orphaned and provider-restricted images are deliberately excluded:
	 * inserting any of them into a message would either expose draft state or
	 * produce content that most readers cannot access.
	 *
	 * @param int $user_id  Active phpBB user identifier
	 * @param int $album_id Optional album filter
	 * @param int $page     Requested page
	 * @param int $per_page Page size
	 * @return array
	 */
	public function get_page(int $user_id, int $album_id = 0, int $page = 1, int $per_page = self::PER_PAGE): array
	{
		$page = max(1, $page);
		$per_page = max(1, min(50, $per_page));
		$viewable_album_ids = $this->get_viewable_album_ids($user_id);

		if ($album_id > 0 && !in_array($album_id, $viewable_album_ids, true))
		{
			return $this->empty_page($album_id, $page, $per_page, false);
		}

		if (empty($viewable_album_ids))
		{
			return $this->empty_page($album_id, 1, $per_page);
		}

		$conditions = $this->get_image_conditions($user_id, $viewable_album_ids);

		$sql = 'SELECT a.album_id, a.album_name, a.left_id,
				COUNT(DISTINCT p.album_id) AS album_depth
			FROM ' . $this->albums_table . ' a
			INNER JOIN ' . $this->images_table . ' i
				ON i.image_album_id = a.album_id
			LEFT JOIN ' . $this->albums_table . ' p
				ON p.left_id < a.left_id
					AND p.right_id > a.right_id
					AND p.album_user_id = a.album_user_id
			WHERE ' . implode(' AND ', $conditions) . '
			GROUP BY a.album_id, a.album_name, a.left_id
			ORDER BY a.left_id ASC, a.album_id ASC';
		$result = $this->db->sql_query($sql);
		$albums = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$albums[] = [
				'album_id'    => (int) $row['album_id'],
				'album_name'  => (string) $row['album_name'],
				'album_depth' => (int) $row['album_depth'],
			];
		}
		$this->db->sql_freeresult($result);

		if ($album_id > 0)
		{
			$conditions[] = 'i.image_album_id = ' . (int) $album_id;
		}
		$where = implode(' AND ', $conditions);

		$sql = 'SELECT COUNT(i.image_id) AS total
			FROM ' . $this->images_table . ' i
			INNER JOIN ' . $this->albums_table . ' a
				ON a.album_id = i.image_album_id
			WHERE ' . $where;
		$result = $this->db->sql_query($sql);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		$total_pages = max(1, (int) ceil($total / $per_page));
		$page = min($page, $total_pages);
		$start = ($page - 1) * $per_page;

		$sql = 'SELECT i.image_id, i.image_name, i.image_album_id, a.album_name
			FROM ' . $this->images_table . ' i
			INNER JOIN ' . $this->albums_table . ' a
				ON a.album_id = i.image_album_id
			WHERE ' . $where . '
			ORDER BY i.image_time DESC, i.image_id DESC';
		$result = $this->db->sql_query_limit($sql, $per_page, $start);
		$images = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$images[] = [
				'image_id'   => (int) $row['image_id'],
				'image_name' => (string) $row['image_name'],
				'album_id'   => (int) $row['image_album_id'],
				'album_name' => (string) $row['album_name'],
			];
		}
		$this->db->sql_freeresult($result);

		return [
			'authorized' => true,
			'album_id'   => $album_id,
			'albums'     => $albums,
			'images'     => $images,
			'pagination' => [
				'page'     => $page,
				'pages'    => $total_pages,
				'per_page' => $per_page,
				'total'    => $total,
			],
		];
	}

	/** @return int[] */
	private function get_viewable_album_ids(int $user_id): array
	{
		$this->gallery_auth->load_user_permissions($user_id);
		$viewable_album_ids = $this->gallery_auth->acl_album_ids('i_view');
		if (!is_array($viewable_album_ids))
		{
			$viewable_album_ids = [];
		}

		$viewable_album_ids = array_values(array_unique(array_filter(array_map('intval', $viewable_album_ids))));
		$excluded_album_ids = array_map('intval', $this->gallery_auth->get_exclude_zebra());
		$viewable_album_ids = array_values(array_diff($viewable_album_ids, $excluded_album_ids));
		sort($viewable_album_ids, SORT_NUMERIC);

		return $viewable_album_ids;
	}

	/**
	 * @param int[] $viewable_album_ids
	 * @return string[]
	 */
	private function get_image_conditions(int $user_id, array $viewable_album_ids): array
	{
		return [
			'i.image_user_id = ' . (int) $user_id,
			$this->db->sql_in_set('i.image_album_id', $viewable_album_ids),
			$this->db->sql_in_set('i.image_status', [
				\phpbbgallery\core\block::STATUS_APPROVED,
				\phpbbgallery\core\block::STATUS_LOCKED,
			]),
			$this->image_visibility->results_sql('i', []),
		];
	}

	private function empty_page(int $album_id, int $page, int $per_page, bool $authorized = true): array
	{
		return [
			'authorized' => $authorized,
			'album_id'   => $album_id,
			'albums'     => [],
			'images'     => [],
			'pagination' => [
				'page'     => $page,
				'pages'    => 1,
				'per_page' => $per_page,
				'total'    => 0,
			],
		];
	}
}
