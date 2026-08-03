<?php
/**
*
* @package phpbbgallery/contest
* @version $Id$
* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/

namespace phpbbgallery\contest;

use phpbbgallery\core\block;

class manager
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

	/**
	 * Recoverable intermediate state while a selected podium is published.
	 */
	private const FINALIZING_CONTEST = 2;

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
	 * Whether administrators may create new contest albums.
	 *
	 * Existing contests deliberately remain operational when this is disabled.
	 */
	public function can_create(): bool
	{
		return (bool) $this->gallery_config->get('allow_contests');
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

	public function get_contests_by_album_ids(array $album_ids): array
	{
		$album_ids = array_values(array_unique(array_filter(
			array_map('intval', $album_ids),
			static fn (int $album_id): bool => $album_id > 0
		)));
		if (!$album_ids)
		{
			return [];
		}
		sort($album_ids);

		$sql = 'SELECT *
			FROM ' . $this->contest_table . '
			WHERE ' . $this->db->sql_in_set('contest_album_id', $album_ids);
		$result = $this->db->sql_query($sql);
		$contests = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$contests[(int) $row['contest_album_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $contests;
	}

	private function get_tabulation(string $alias = ''): string
	{
		$prefix = $alias !== '' ? $alias . '.' : '';

		return self::$mode === self::MODE_SUM
			? $prefix . 'image_rate_points DESC, ' . $prefix . 'image_rate_avg DESC, ' . $prefix . 'image_id ASC'
			: $prefix . 'image_rate_avg DESC, ' . $prefix . 'image_rate_points DESC, ' . $prefix . 'image_id ASC';
	}

	/**
	 * Check whether a Gallery action is available in the current contest phase.
	 *
	 * Regular albums are not subject to contest phases. A contest album without
	 * a complete contest row is rejected so broken data cannot silently bypass
	 * the phase restrictions.
	 *
	 * @param string   $mode       Action to check: upload, rate or comment
	 * @param array    $album_data Album data, including its contest row
	 * @param int|null $now        Current timestamp, injectable for tests
	 * @return bool
	 */
	public static function is_step(string $mode, array $album_data, ?int $now = null): bool
	{
		if (!in_array($mode, ['upload', 'rate', 'comment'], true))
		{
			return false;
		}

		$is_contest = isset($album_data['album_type'])
			? (int) $album_data['album_type'] === (int) block::TYPE_CONTEST
			: !empty($album_data['contest_id']);

		if (!$is_contest)
		{
			return true;
		}

		$required_fields = ['contest_id', 'contest_start', 'contest_rating', 'contest_end'];
		foreach ($required_fields as $field)
		{
			if (!isset($album_data[$field]) || !is_numeric($album_data[$field]))
			{
				return false;
			}
		}

		$contest_id = (int) $album_data['contest_id'];
		$start = (int) $album_data['contest_start'];
		$rating_delay = (int) $album_data['contest_rating'];
		$duration = (int) $album_data['contest_end'];
		if ($contest_id <= 0 || $start < 0 || $rating_delay < 0 || $duration < $rating_delay)
		{
			return false;
		}

		$now ??= time();
		$rating_start = $start + $rating_delay;
		$end = $start + $duration;

		return match ($mode)
		{
			'upload' => $start <= $now && $now < $rating_start,
			'rate' => $rating_start <= $now && $now < $end,
			'comment' => $now >= $end,
		};
	}

	/**
	 * Check whether an image still belongs to an active, anonymous contest.
	 *
	 * The persisted marker is authoritative. It is cleared only after contest
	 * finalization, so incomplete or delayed finalization remains fail-closed.
	 *
	 * @param array $image_data Image data
	 * @return bool
	 */
	public static function is_active_image(array $image_data): bool
	{
		return (int) ($image_data['image_contest'] ?? block::NO_CONTEST) === (int) block::IN_CONTEST;
	}

	/**
	 * Decide whether an active contest image must hide its author and description.
	 *
	 * Moderators may inspect every entry. A registered author may inspect their
	 * own entry, while anonymous entries never receive an owner exception.
	 *
	 * @param array $image_data  Image data
	 * @param int   $viewer_id   Current user identifier
	 * @param bool  $can_moderate Whether the viewer can moderate image status
	 * @return bool
	 */
	public static function hides_private_data(array $image_data, int $viewer_id, bool $can_moderate): bool
	{
		if (!self::is_active_image($image_data) || $can_moderate)
		{
			return false;
		}

		$anonymous_id = defined('ANONYMOUS') ? (int) constant('ANONYMOUS') : 1;
		$owner_id = (int) ($image_data['image_user_id'] ?? $anonymous_id);

		return $owner_id === $anonymous_id || $owner_id !== $viewer_id;
	}

	/**
	 * Decide whether aggregate ratings and comment history must remain hidden.
	 *
	 * Unlike identity data, contest results stay private even from the entry
	 * author. Only an album status moderator may inspect them before finalization.
	 *
	 * @param array $image_data  Image data
	 * @param bool  $can_moderate Whether the viewer can moderate image status
	 * @return bool
	 */
	public static function hides_results(array $image_data, bool $can_moderate): bool
	{
		return self::is_active_image($image_data) && !$can_moderate;
	}

	/**
	 * Build the SQL boundary for fields covered by the author exception.
	 *
	 * @param string $alias               Optional, trusted image-table alias
	 * @param int    $viewer_id           Current user identifier
	 * @param array  $moderated_album_ids Albums where the viewer may moderate status
	 * @return string
	 */
	public static function private_data_visibility_sql(string $alias, int $viewer_id, array $moderated_album_ids): string
	{
		$prefix = self::sql_alias_prefix($alias);
		$visibility = [$prefix . 'image_contest = ' . (int) block::NO_CONTEST];
		$anonymous_id = defined('ANONYMOUS') ? (int) constant('ANONYMOUS') : 1;

		if ($viewer_id > 0 && $viewer_id !== $anonymous_id)
		{
			$visibility[] = $prefix . 'image_user_id = ' . $viewer_id;
		}

		$moderated_album_ids = self::normalize_album_ids($moderated_album_ids);
		if ($moderated_album_ids)
		{
			$visibility[] = $prefix . 'image_album_id IN (' . implode(', ', $moderated_album_ids) . ')';
		}

		return '(' . implode(' OR ', $visibility) . ')';
	}

	/**
	 * Build the SQL boundary for ratings and comment history.
	 *
	 * @param string $alias               Optional, trusted image-table alias
	 * @param array  $moderated_album_ids Albums where the viewer may moderate status
	 * @return string
	 */
	public static function results_visibility_sql(string $alias, array $moderated_album_ids): string
	{
		$prefix = self::sql_alias_prefix($alias);
		$visibility = [$prefix . 'image_contest = ' . (int) block::NO_CONTEST];
		$moderated_album_ids = self::normalize_album_ids($moderated_album_ids);

		if ($moderated_album_ids)
		{
			$visibility[] = $prefix . 'image_album_id IN (' . implode(', ', $moderated_album_ids) . ')';
		}

		return '(' . implode(' OR ', $visibility) . ')';
	}

	/**
	 * Validate an internal SQL alias before using it as an identifier prefix.
	 *
	 * @param string $alias Table alias
	 * @return string
	 */
	private static function sql_alias_prefix(string $alias): string
	{
		if ($alias === '')
		{
			return '';
		}

		if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $alias))
		{
			throw new \InvalidArgumentException('Invalid SQL alias.');
		}

		return $alias . '.';
	}

	/**
	 * Normalize album identifiers embedded in policy SQL.
	 *
	 * @param array $album_ids Album identifiers
	 * @return array
	 */
	private static function normalize_album_ids(array $album_ids): array
	{
		return array_values(array_unique(array_filter(
			array_map('intval', $album_ids),
			static fn(int $album_id): bool => $album_id > 0
		)));
	}

	/**
	 * Finalize a due contest and persist its deterministic podium.
	 *
	 * The selected podium is first claimed in a recoverable intermediate state
	 * and then published in one idempotent image update. Concurrent requests use
	 * the stored podium and only the request completing the state transition
	 * increments the completed-contest statistic.
	 *
	 * @param int      $album_id  Contest album identifier
	 * @param int      $contest_id Contest identifier
	 * @param int      $end_time  Scheduled contest end timestamp
	 * @param int|null $now       Current timestamp override for deterministic tests
	 * @return bool Whether this request completed or recovered the finalization
	 */
	public function end(int $album_id, int $contest_id, int $end_time, ?int $now = null): bool
	{
		if ($album_id <= 0 || $contest_id <= 0 || $end_time <= 0)
		{
			return false;
		}

		$now ??= time();
		$sql = 'SELECT contest_marked, contest_first, contest_second, contest_third
			FROM ' . $this->contest_table . '
			WHERE contest_id = ' . (int) $contest_id . '
				AND contest_album_id = ' . (int) $album_id . '
				AND contest_marked IN (' . (int) block::IN_CONTEST . ', ' . self::FINALIZING_CONTEST . ')
				AND contest_start + contest_end = ' . (int) $end_time . '
				AND contest_start + contest_end <= ' . (int) $now;
		$result = $this->db->sql_query_limit($sql, 1);
		$contest = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$contest)
		{
			return false;
		}

		if ((int) $contest['contest_marked'] === (int) block::IN_CONTEST)
		{
			$winners = $this->select_winners($album_id);
			$first = $winners[0] ?? 0;
			$second = $winners[1] ?? 0;
			$third = $winners[2] ?? 0;
			$sql = 'UPDATE ' . $this->contest_table . '
				SET contest_marked = ' . self::FINALIZING_CONTEST . ',
					contest_first = ' . (int) $first . ',
					contest_second = ' . (int) $second . ',
					contest_third = ' . (int) $third . '
				WHERE contest_id = ' . (int) $contest_id . '
					AND contest_album_id = ' . (int) $album_id . '
					AND contest_marked = ' . (int) block::IN_CONTEST . '
					AND contest_start + contest_end = ' . (int) $end_time;
			$this->db->sql_query($sql);

			if ((int) $this->db->sql_affectedrows() !== 1)
			{
				$contest = $this->get_finalizing_contest($album_id, $contest_id, $end_time);
				if (!$contest)
				{
					return false;
				}
				$winners = $this->stored_winners($contest);
			}
		}
		else
		{
			$winners = $this->stored_winners($contest);
		}

		$this->persist_podium($album_id, $end_time, $winners);

		$sql = 'UPDATE ' . $this->contest_table . '
			SET contest_marked = ' . self::NO_CONTEST . '
			WHERE contest_id = ' . (int) $contest_id . '
				AND contest_album_id = ' . (int) $album_id . '
				AND contest_marked = ' . self::FINALIZING_CONTEST . '
				AND contest_start + contest_end = ' . (int) $end_time;
		$this->db->sql_query($sql);

		if ((int) $this->db->sql_affectedrows() === 1)
		{
			$this->gallery_config->inc('contests_ended', 1);
		}

		return true;
	}

	/**
	 * Select the eligible participants for the contest podium.
	 *
	 * @param int $album_id Contest album identifier
	 * @return int[]
	 */
	private function select_winners(int $album_id): array
	{
		$sql = 'SELECT image_id
			FROM ' . $this->images_table . '
			WHERE image_album_id = ' . (int) $album_id . '
				AND image_contest = ' . (int) block::IN_CONTEST . '
				AND ' . $this->db->sql_in_set('image_status', [
					block::STATUS_APPROVED,
					block::STATUS_LOCKED,
				]) . '
			ORDER BY ' . $this->get_tabulation();
		$result = $this->db->sql_query_limit($sql, self::NUM_IMAGES);
		$winners = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$winners[] = (int) $row['image_id'];
		}
		$this->db->sql_freeresult($result);

		return $winners;
	}

	/**
	 * Reload a podium already claimed by a concurrent finalizer.
	 *
	 * @param int $album_id  Contest album identifier
	 * @param int $contest_id Contest identifier
	 * @param int $end_time  Scheduled contest end timestamp
	 * @return array|false
	 */
	private function get_finalizing_contest(int $album_id, int $contest_id, int $end_time): array|false
	{
		$sql = 'SELECT contest_first, contest_second, contest_third
			FROM ' . $this->contest_table . '
			WHERE contest_id = ' . (int) $contest_id . '
				AND contest_album_id = ' . (int) $album_id . '
				AND contest_marked = ' . self::FINALIZING_CONTEST . '
				AND contest_start + contest_end = ' . (int) $end_time;
		$result = $this->db->sql_query_limit($sql, 1);
		$contest = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $contest ?: false;
	}

	/**
	 * Convert the stored podium columns into ordered, non-zero image IDs.
	 *
	 * @param array $contest Contest row
	 * @return int[]
	 */
	private function stored_winners(array $contest): array
	{
		return array_values(array_filter([
			(int) ($contest['contest_first'] ?? 0),
			(int) ($contest['contest_second'] ?? 0),
			(int) ($contest['contest_third'] ?? 0),
		]));
	}

	/**
	 * Publish a stored podium and clear every active image marker atomically.
	 *
	 * @param int   $album_id Contest album identifier
	 * @param int   $end_time Scheduled contest end timestamp
	 * @param int[] $winners  Ordered winner image identifiers
	 * @return void
	 */
	private function persist_podium(int $album_id, int $end_time, array $winners): void
	{
		$rank_cases = [];
		foreach ($winners as $rank => $image_id)
		{
			$rank_cases[] = 'WHEN ' . (int) $image_id . ' THEN ' . ((int) $rank + 1);
		}

		$rank_sql = $rank_cases ? 'CASE image_id ' . implode(' ', $rank_cases) . ' ELSE 0 END' : '0';
		$sql = 'UPDATE ' . $this->images_table . '
			SET image_contest_end = CASE
					WHEN image_contest = ' . (int) block::IN_CONTEST . '
						OR image_contest_end = ' . (int) $end_time . ' THEN ' . (int) $end_time . '
					ELSE 0
				END,
				image_contest_rank = ' . $rank_sql . ',
				image_contest = ' . self::NO_CONTEST . '
			WHERE image_album_id = ' . (int) $album_id;
		$this->db->sql_query($sql);
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
			$sql = 'SELECT contest_album_id, contest_start, contest_end
				FROM ' . $this->contest_table . '
				WHERE ' . $this->db->sql_in_set('contest_album_id', $album_batch) . '
					AND contest_marked = ' . self::NO_CONTEST;
			$result = $this->db->sql_query($sql);
			$contest_end_times = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$contest_end_times[(int) $row['contest_album_id']] = (int) $row['contest_start'] + (int) $row['contest_end'];
			}
			$this->db->sql_freeresult($result);
			if (!$contest_end_times)
			{
				continue;
			}

			$participant_sql = $this->participant_sql('', $contest_end_times);
			$sql = 'UPDATE ' . $this->images_table . '
				SET image_contest_rank = 0
				WHERE ' . $participant_sql;
			$this->db->sql_query($sql);

			$ranked_status_sql = $this->eligible_status_sql('ranked.image_status');
			$better_status_sql = $this->eligible_status_sql('better.image_status');
			$sql = sprintf(
				'SELECT ranked.image_album_id, ranked.image_id
				FROM ' . $this->images_table . ' ranked
				WHERE %s
					AND %s
					AND (SELECT COUNT(better.image_id)
						FROM ' . $this->images_table . ' better
						WHERE better.image_album_id = ranked.image_album_id
							AND better.image_contest_end = ranked.image_contest_end
							AND %s
							AND (%s)) < %d
				ORDER BY ranked.image_album_id ASC, %s',
				$this->participant_sql('ranked', $contest_end_times),
				$ranked_status_sql,
				$better_status_sql,
				$this->get_better_image_condition(),
				self::NUM_IMAGES,
				$this->get_tabulation('ranked')
			);
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

			$completed_album_ids = array_keys($contest_end_times);
			$sql = 'UPDATE ' . $this->contest_table . '
				SET ' . implode(",\n\t\t\t\t\t", $contest_updates) . '
				WHERE ' . $this->db->sql_in_set('contest_album_id', $completed_album_ids) . '
					AND contest_marked = ' . self::NO_CONTEST;
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

	private function get_better_image_condition(): string
	{
		$first_column = self::$mode === self::MODE_SUM ? 'image_rate_points' : 'image_rate_avg';
		$second_column = self::$mode === self::MODE_SUM ? 'image_rate_avg' : 'image_rate_points';

		return 'better.' . $first_column . ' > ranked.' . $first_column . '
			OR (better.' . $first_column . ' = ranked.' . $first_column . '
				AND better.' . $second_column . ' > ranked.' . $second_column . ')
			OR (better.' . $first_column . ' = ranked.' . $first_column . '
				AND better.' . $second_column . ' = ranked.' . $second_column . '
				AND better.image_id < ranked.image_id)';
	}

	/**
	 * SQL predicate for images eligible for a completed contest podium.
	 *
	 * @param string $column Qualified image-status column
	 * @return string
	 */
	private function eligible_status_sql(string $column): string
	{
		return $this->db->sql_in_set($column, [
			block::STATUS_APPROVED,
			block::STATUS_LOCKED,
		]);
	}

	/**
	 * Match images proven to belong to each completed contest.
	 *
	 * @param string $alias             Optional image-table alias
	 * @param array  $contest_end_times Contest end timestamp keyed by album ID
	 * @return string
	 */
	private function participant_sql(string $alias, array $contest_end_times): string
	{
		$prefix = self::sql_alias_prefix($alias);
		$conditions = [];
		foreach ($contest_end_times as $album_id => $end_time)
		{
			$conditions[] = '(' . $prefix . 'image_album_id = ' . (int) $album_id . '
				AND ' . $prefix . 'image_contest_end = ' . (int) $end_time . ')';
		}

		return '(' . implode(' OR ', $conditions) . ')';
	}
}
