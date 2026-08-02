<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite;

/**
 * Stores which images a member has bookmarked.
 *
 * Every write keeps the denormalised gallery_images.image_favorited counter in
 * step with the rows actually written, so the counter cannot drift when an
 * image is favourited twice or unfavourited without being favourited first.
 */
class favorite
{
	/**
	 * Subscribe to the images a member favourites, by default.
	 */
	public const DEFAULT_SUBSCRIBE = false;

	/* @var \phpbb\db\driver\driver_interface */
	protected \phpbb\db\driver\driver_interface $db;

	/* @var string */
	protected string $favorites_table;

	/* @var string */
	protected string $images_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db              Database object
	 * @param string                            $favorites_table Gallery favorites table
	 * @param string                            $images_table    Gallery images table
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, string $favorites_table, string $images_table)
	{
		$this->db = $db;
		$this->favorites_table = $favorites_table;
		$this->images_table = $images_table;
	}

	/**
	 * Add images to a member's favourites.
	 *
	 * Images that are already favourited are skipped, so the counter is only
	 * raised for rows that were really inserted.
	 *
	 * @param array|int $image_ids Images to add
	 * @param int       $user_id   Member the favourites belong to
	 * @return int Number of images actually added
	 */
	public function add(array|int $image_ids, int $user_id): int
	{
		$image_ids = $this->cast_to_id_array($image_ids);

		if (empty($image_ids) || $user_id <= 0)
		{
			return 0;
		}

		$this->db->sql_transaction('begin');

		$new_ids = array_values(array_diff($image_ids, $this->get_favorited_ids($image_ids, $user_id)));

		if (empty($new_ids))
		{
			$this->db->sql_transaction('commit');

			return 0;
		}

		$rows = [];
		foreach ($new_ids as $image_id)
		{
			$rows[] = [
				'user_id'	=> $user_id,
				'image_id'	=> $image_id,
			];
		}
		$this->db->sql_multi_insert($this->favorites_table, $rows);

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_favorited = image_favorited + 1
			WHERE ' . $this->db->sql_in_set('image_id', $new_ids);
		$this->db->sql_query($sql);

		// An image can be deleted after the initial favourite check but before
		// this write finishes. Keep only relations whose image still exists;
		// the Core delete event covers the opposite ordering of the race.
		$existing_ids = $this->get_existing_image_ids($new_ids);
		$missing_ids = array_values(array_diff($new_ids, $existing_ids));
		if (!empty($missing_ids))
		{
			$sql = 'DELETE FROM ' . $this->favorites_table . '
				WHERE user_id = ' . (int) $user_id . '
					AND ' . $this->db->sql_in_set('image_id', $missing_ids);
			$this->db->sql_query($sql);
		}

		$this->db->sql_transaction('commit');

		return count($existing_ids);
	}

	/**
	 * Return the requested image ids that still exist in the Core table.
	 *
	 * @param array $image_ids Image ids to verify
	 * @return array
	 */
	private function get_existing_image_ids(array $image_ids): array
	{
		$existing_ids = [];
		$sql = 'SELECT image_id
			FROM ' . $this->images_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$existing_ids[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);

		return $existing_ids;
	}

	/**
	 * Remove images from a member's favourites.
	 *
	 * Only images that were really favourited are counted down, so a repeated
	 * or forged removal cannot push the counter below zero.
	 *
	 * @param array|int $image_ids Images to remove
	 * @param int       $user_id   Member the favourites belong to
	 * @return int Number of images actually removed
	 */
	public function remove(array|int $image_ids, int $user_id): int
	{
		$image_ids = $this->cast_to_id_array($image_ids);

		if (empty($image_ids) || $user_id <= 0)
		{
			return 0;
		}

		$this->db->sql_transaction('begin');

		$known_ids = $this->get_favorited_ids($image_ids, $user_id);

		if (empty($known_ids))
		{
			$this->db->sql_transaction('commit');

			return 0;
		}

		$sql = 'DELETE FROM ' . $this->favorites_table . '
			WHERE user_id = ' . (int) $user_id . '
				AND ' . $this->db->sql_in_set('image_id', $known_ids);
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_favorited = image_favorited - 1
			WHERE ' . $this->db->sql_in_set('image_id', $known_ids) . '
				AND image_favorited > 0';
		$this->db->sql_query($sql);

		$this->db->sql_transaction('commit');

		return count($known_ids);
	}

	/**
	 * Which of these images has the member already favourited?
	 *
	 * @param array|int $image_ids Images to look up
	 * @param int       $user_id   Member the favourites belong to
	 * @return array Image ids, as integers
	 */
	public function get_favorited_ids(array|int $image_ids, int $user_id): array
	{
		$image_ids = $this->cast_to_id_array($image_ids);

		if (empty($image_ids) || $user_id <= 0)
		{
			return [];
		}

		$favorited = [];

		$sql = 'SELECT image_id
			FROM ' . $this->favorites_table . '
			WHERE user_id = ' . (int) $user_id . '
				AND ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$favorited[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);

		return $favorited;
	}

	/**
	 * Has the member favourited this image?
	 *
	 * @param int $image_id Image to look up
	 * @param int $user_id  Member the favourite belongs to
	 * @return bool
	 */
	public function is_favorited(int $image_id, int $user_id): bool
	{
		return !empty($this->get_favorited_ids([$image_id], $user_id));
	}

	/**
	 * How many favourites does a member have?
	 *
	 * @param int $user_id Member the favourites belong to
	 * @return int
	 */
	public function count_for_user(int $user_id): int
	{
		$sql = 'SELECT COUNT(favorite_id) AS favorites
			FROM ' . $this->favorites_table . '
			WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return (int) ($row['favorites'] ?? 0);
	}

	/**
	 * Drop every favourite pointing at these images, for all members.
	 *
	 * Called when images are deleted, so the counter on the vanishing rows is
	 * not worth updating.
	 *
	 * @param array|int $image_ids Images being deleted
	 * @return void
	 */
	public function delete_images(array|int $image_ids): void
	{
		$image_ids = $this->cast_to_id_array($image_ids);

		if (empty($image_ids))
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->favorites_table . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$this->db->sql_query($sql);
	}

	/**
	 * Drop every favourite belonging to these members.
	 *
	 * Unlike image deletion the images stay, so their counters are corrected.
	 *
	 * @param array|int $user_ids Members being deleted
	 * @return void
	 */
	public function delete_users(array|int $user_ids): void
	{
		$user_ids = $this->cast_to_id_array($user_ids);

		if (empty($user_ids))
		{
			return;
		}

		$this->db->sql_transaction('begin');

		$image_ids = [];
		$sql = 'SELECT image_id
			FROM ' . $this->favorites_table . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$image_ids[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);

		$sql = 'DELETE FROM ' . $this->favorites_table . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
		$this->db->sql_query($sql);

		foreach (array_count_values($image_ids) as $image_id => $lost)
		{
			$sql = 'UPDATE ' . $this->images_table . '
				SET image_favorited = image_favorited - ' . (int) $lost . '
				WHERE image_id = ' . (int) $image_id . '
					AND image_favorited >= ' . (int) $lost;
			$this->db->sql_query($sql);
		}

		$this->db->sql_transaction('commit');
	}

	/**
	 * Recalculate every image_favorited counter from the favourites themselves.
	 *
	 * Boards upgraded from the old gallery MOD can carry counters that were
	 * never kept in step, so this repairs them in two statements.
	 *
	 * @return void
	 */
	public function resync_counters(): void
	{
		$counts = [];

		$sql = 'SELECT image_id, COUNT(favorite_id) AS favorites
			FROM ' . $this->favorites_table . '
			GROUP BY image_id';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$counts[(int) $row['favorites']][] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);

		$this->db->sql_transaction('begin');

		$known_ids = [];
		foreach ($counts as $favorites => $image_ids)
		{
			$known_ids = array_merge($known_ids, $image_ids);

			$sql = 'UPDATE ' . $this->images_table . '
				SET image_favorited = ' . (int) $favorites . '
				WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
			$this->db->sql_query($sql);
		}

		// Anything with no favourites left must report zero.
		$sql = 'UPDATE ' . $this->images_table . '
			SET image_favorited = 0
			WHERE image_favorited <> 0';
		if (!empty($known_ids))
		{
			$sql .= ' AND ' . $this->db->sql_in_set('image_id', $known_ids, true);
		}
		$this->db->sql_query($sql);

		$this->db->sql_transaction('commit');
	}

	/**
	 * Remove favourites whose Core image disappeared while this addon was disabled.
	 */
	public function reconcile_orphans(int $batch_size = 500): int
	{
		$deleted = 0;
		$batch_size = max(1, min(1000, $batch_size));
		do
		{
			$sql = 'SELECT DISTINCT favorite.image_id
				FROM ' . $this->favorites_table . ' favorite
				LEFT JOIN ' . $this->images_table . ' image
					ON image.image_id = favorite.image_id
				WHERE image.image_id IS NULL';
			$result = $this->db->sql_query_limit($sql, $batch_size);
			$image_ids = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$image_ids[] = (int) $row['image_id'];
			}
			$this->db->sql_freeresult($result);
			if (!$image_ids)
			{
				break;
			}

			$sql = 'DELETE FROM ' . $this->favorites_table . '
				WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
			$this->db->sql_query($sql);
			$affected = (int) $this->db->sql_affectedrows();
			$deleted += $affected;
		}
		while ($affected > 0);

		return $deleted;
	}

	/**
	 * Normalise a scalar or array of ids into a list of unique positive ints.
	 *
	 * @param array|int $ids Ids to normalise
	 * @return array
	 */
	protected function cast_to_id_array(array|int $ids): array
	{
		$ids = array_map('intval', (array) $ids);

		return array_values(array_unique(array_filter($ids, static fn (int $id): bool => $id > 0)));
	}
}
