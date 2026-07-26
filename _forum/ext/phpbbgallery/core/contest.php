<?php
/**
*
* @package phpBB Gallery
* @version $Id$
* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/

namespace phpbbgallery\core;

class contest
{
	/**
	 * @var \phpbb\db\driver\driver_interface
	 */
	private \phpbb\db\driver\driver_interface $db;

	/**
	 * @var \phpbbgallery\core\config
	 */
	private \phpbbgallery\core\config $gallery_config;

	/**
	 * @var string
	 */
	private string $images_table;

	/**
	 * @var string
	 */
	private string $contest_table;

	/**
	 * Contest state written to images and contest rows after tabulation.
	 */
	private const NO_CONTEST = 0;

	public const NUM_IMAGES = 3;

	/**
	* There are different modes to calculate who won the contest.
	* This value should be one of the constant-names below.
	*/
	public static int $mode = self::MODE_AVERAGE;

	/**
	* The image with the highest average wins.
	*/
	public const MODE_AVERAGE = 1;
	/**
	* The image with the highest number of total points wins.
	*/
	public const MODE_SUM = 2;

	public function __construct(\phpbb\db\driver\driver_interface $db,
								\phpbbgallery\core\config $gallery_config,
								string $images_table, string $contests_table)
	{
		$this->db = $db;
		$this->gallery_config = $gallery_config;
		$this->images_table = $images_table;
		$this->contest_table = $contests_table;
	}

	/**
	* Get the contest row from the table
	*
	* @param	int		$id				ID of the contest or album, depending on second parameter
	* @param	string	$mode			contest or album ID to get the contest.
	* @param	bool	$throw_error	Shall we throw an error if the contest was not found?
	*
	* @return	array|false	Either the contest row or false if the contest does not exist
	*/
	public function get_contest(int $id, string $mode = 'contest', bool $throw_error = true): array|false
	{
		$sql = 'SELECT *
			FROM ' . $this->contest_table . '
			WHERE ' . (($mode === 'album') ? 'contest_album_id' : 'contest_id') . ' = ' . (int) $id;
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row && $throw_error)
		{
			trigger_error('NO_CONTEST', E_USER_ERROR);
		}

		return (!$row) ? false : $row;
	}

	private function get_tabulation(string $alias = ''): string
	{
		$prefix = $alias !== '' ? $alias . '.' : '';

		return self::$mode === self::MODE_SUM
			? $prefix . 'image_rate_points DESC, ' . $prefix . 'image_rate_avg DESC, ' . $prefix . 'image_id ASC'
			: $prefix . 'image_rate_avg DESC, ' . $prefix . 'image_rate_points DESC, ' . $prefix . 'image_id ASC';
	}

	public function is_step(string $mode, array $album_data): bool
	{
		$current_time = time();

		return match ($mode)
		{
			'upload' => !$album_data['contest_id'] || ($album_data['contest_start'] < $current_time &&
				$current_time < $album_data['contest_start'] + $album_data['contest_rating']),
			'rate' => !$album_data['contest_id'] || ($album_data['contest_start'] + $album_data['contest_rating'] < $current_time &&
				$current_time < $album_data['contest_start'] + $album_data['contest_end']),
			'comment' => !$album_data['contest_id'] || $current_time > $album_data['contest_start'] + $album_data['contest_end'],
			default => false,
		};
	}

	public function end(int $album_id, int $contest_id, int $end_time): void
	{
		$sql = 'UPDATE ' . $this->images_table . '
			SET image_contest = ' . self::NO_CONTEST . '
			WHERE image_album_id = ' . (int) $album_id;
		$this->db->sql_query($sql);

		$sql = 'SELECT image_id
			FROM ' . $this->images_table . '
			WHERE image_album_id = ' . (int) $album_id . '
			ORDER BY ' .$this->get_tabulation();
		$result = $this->db->sql_query_limit($sql, self::NUM_IMAGES);
		$first = $this->db->sql_fetchfield('image_id');
		$second = $this->db->sql_fetchfield('image_id');
		$third = $this->db->sql_fetchfield('image_id');
		$this->db->sql_freeresult($result);

		$first = (int) $first;
		$second = (int) $second;
		$third = (int) $third;

		$sql = 'UPDATE ' . $this->contest_table . '
			SET contest_marked = ' . self::NO_CONTEST . ",
				contest_first = $first,
				contest_second = $second,
				contest_third = $third
			WHERE contest_id = " . (int) $contest_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_contest_end = ' . (int) $end_time . ',
				image_contest_rank = 1
			WHERE image_id = ' . $first;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_contest_end = ' . (int) $end_time . ',
				image_contest_rank = 2
			WHERE image_id = ' . $second;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->images_table . '
			SET image_contest_end = ' . (int) $end_time . ',
				image_contest_rank = 3
			WHERE image_id = ' . $third;
		$this->db->sql_query($sql);

		$this->gallery_config->inc('contests_ended', 1);
	}

	public function resync_albums(array|int $album_ids): void
	{
		$album_ids = is_array($album_ids) ? $album_ids : [$album_ids];
		$album_ids = array_values(array_unique(array_filter(
			array_map('intval', $album_ids),
			static fn(int $album_id): bool => $album_id > 0
		)));

		foreach (array_chunk($album_ids, 100) as $album_batch)
		{
			$sql = 'UPDATE ' . $this->images_table . '
				SET image_contest = ' . self::NO_CONTEST . ',
					image_contest_rank = 0
				WHERE ' . $this->db->sql_in_set('image_album_id', $album_batch);
			$this->db->sql_query($sql);

			$sql = 'SELECT ranked.image_album_id, ranked.image_id
				FROM ' . $this->images_table . ' ranked
				WHERE ' . $this->db->sql_in_set('ranked.image_album_id', $album_batch) . '
					AND (SELECT COUNT(better.image_id)
						FROM ' . $this->images_table . ' better
						WHERE better.image_album_id = ranked.image_album_id
							AND (' . $this->get_better_image_condition('better', 'ranked') . ')) < ' . self::NUM_IMAGES . '
				ORDER BY ranked.image_album_id ASC, ' . $this->get_tabulation('ranked');
			$result = $this->db->sql_query($sql);
			$winners = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$winners[(int) $row['image_album_id']][] = (int) $row['image_id'];
			}
			$this->db->sql_freeresult($result);

			$contest_columns = [
				'contest_first',
				'contest_second',
				'contest_third',
			];
			$contest_updates = [];
			foreach ($contest_columns as $rank => $column)
			{
				$cases = [];
				foreach ($album_batch as $album_id)
				{
					$image_id = $winners[$album_id][$rank] ?? 0;
					$cases[] = 'WHEN ' . $album_id . ' THEN ' . $image_id;
				}
				$contest_updates[] = $column . ' = CASE contest_album_id ' . implode(' ', $cases) . ' ELSE ' . $column . ' END';
			}

			$sql = 'UPDATE ' . $this->contest_table . '
				SET ' . implode(",\n\t\t\t\t\t", $contest_updates) . '
				WHERE ' . $this->db->sql_in_set('contest_album_id', $album_batch);
			$this->db->sql_query($sql);

			$image_ranks = [];
			foreach ($winners as $album_winners)
			{
				foreach ($album_winners as $rank => $image_id)
				{
					$image_ranks[$image_id] = $rank + 1;
				}
			}

			if ($image_ranks)
			{
				$cases = [];
				foreach ($image_ranks as $image_id => $rank)
				{
					$cases[] = 'WHEN ' . $image_id . ' THEN ' . $rank;
				}

				$sql = 'UPDATE ' . $this->images_table . '
					SET image_contest_rank = CASE image_id ' . implode(' ', $cases) . ' ELSE image_contest_rank END
					WHERE ' . $this->db->sql_in_set('image_id', array_keys($image_ranks));
				$this->db->sql_query($sql);
			}
		}
	}

	public function resync(int $album_id): void
	{
		$this->resync_albums([$album_id]);
	}

	private function get_better_image_condition(string $better_alias, string $ranked_alias): string
	{
		$first_column = self::$mode === self::MODE_SUM ? 'image_rate_points' : 'image_rate_avg';
		$second_column = self::$mode === self::MODE_SUM ? 'image_rate_avg' : 'image_rate_points';

		return $better_alias . '.' . $first_column . ' > ' . $ranked_alias . '.' . $first_column . '
			OR (' . $better_alias . '.' . $first_column . ' = ' . $ranked_alias . '.' . $first_column . '
				AND ' . $better_alias . '.' . $second_column . ' > ' . $ranked_alias . '.' . $second_column . ')
			OR (' . $better_alias . '.' . $first_column . ' = ' . $ranked_alias . '.' . $first_column . '
				AND ' . $better_alias . '.' . $second_column . ' = ' . $ranked_alias . '.' . $second_column . '
				AND ' . $better_alias . '.image_id < ' . $ranked_alias . '.image_id)';
	}
}
