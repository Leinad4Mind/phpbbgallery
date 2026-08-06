<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\core;

/**
 * Builds per-option scoring distributions from aggregated database rows.
 */
final class score_distribution
{
	/**
	 * Convert database rows into option => score => voter count maps.
	 *
	 * @param array $rows Aggregated score rows
	 * @return array
	 */
	public static function from_rows(array $rows)
	{
		$distribution = array();
		foreach ($rows as $row)
		{
			$option_id = (int) $row['poll_option_id'];
			$score = (int) $row['score_value'];
			$voters = (int) $row['voter_count'];

			if ($option_id <= 0 || $score <= 0 || $voters <= 0)
			{
				continue;
			}

			$distribution[$option_id][$score] = $voters;
		}

		foreach ($distribution as &$scores)
		{
			ksort($scores, SORT_NUMERIC);
		}
		unset($scores);

		return $distribution;
	}
}
