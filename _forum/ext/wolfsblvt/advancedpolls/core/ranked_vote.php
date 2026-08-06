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
 * Normalises and validates ranked poll configuration and vote payloads.
 */
final class ranked_vote
{
	const MAX_POSITIONS = 50;

	/**
	 * Convert request or stored values to a clean points list.
	 *
	 * @param array|string $points Point values
	 * @return array
	 */
	public static function normalise_points($points)
	{
		if (is_string($points))
		{
			$points = $points === '' ? array() : explode(',', $points);
		}

		$normalised = array();
		foreach ((array) $points as $point)
		{
			$normalised[] = (int) $point;
		}

		return $normalised;
	}

	/**
	 * Validate creator configuration.
	 *
	 * Points must be positive and strictly decrease so the first selection
	 * always receives the highest value.
	 *
	 * @param int   $positions Number of ranked positions
	 * @param array $points Points for each position
	 * @param int   $option_count Number of available poll options, if known
	 * @return string|false Language key on failure, false on success
	 */
	public static function validate_configuration($positions, array $points, $option_count = 0)
	{
		$positions = (int) $positions;
		$option_count = (int) $option_count;
		if ($positions < 1 || $positions > self::MAX_POSITIONS || ($option_count > 0 && $positions > $option_count))
		{
			return 'AP_RANK_POSITIONS_INVALID';
		}

		if (count($points) !== $positions)
		{
			return 'AP_RANK_POINTS_INCOMPLETE';
		}

		$previous = null;
		foreach ($points as $point)
		{
			$point = (int) $point;
			if ($point < 1 || $point > 999)
			{
				return 'AP_RANK_POINTS_INVALID';
			}
			if ($previous !== null && $point >= $previous)
			{
				return 'AP_RANK_POINTS_ORDER';
			}
			$previous = $point;
		}

		return false;
	}

	/**
	 * Validate the option => point map produced by the ranked frontend.
	 *
	 * @param array $votes Submitted option => point map
	 * @param array $valid_option_ids Valid options belonging to the poll
	 * @param array $points Points configured for positions
	 * @param int   $required_positions Exact number of required positions
	 * @return string|false Language key on failure, false on success
	 */
	public static function validate_vote(array $votes, array $valid_option_ids, array $points, $required_positions)
	{
		$valid = array_fill_keys(array_map('intval', $valid_option_ids), true);

		if (count($votes) !== (int) $required_positions)
		{
			return 'AP_RANK_SELECTION_INCOMPLETE';
		}

		$submitted_points = array();
		foreach ($votes as $option_id => $point)
		{
			$option_id = (int) $option_id;
			$point = (int) $point;
			if (!isset($valid[$option_id]))
			{
				return 'FORM_INVALID';
			}
			$submitted_points[] = $point;
		}

		sort($submitted_points, SORT_NUMERIC);
		$expected_points = array_values(array_map('intval', $points));
		sort($expected_points, SORT_NUMERIC);
		return $submitted_points === $expected_points ? false : 'FORM_INVALID';
	}
}
