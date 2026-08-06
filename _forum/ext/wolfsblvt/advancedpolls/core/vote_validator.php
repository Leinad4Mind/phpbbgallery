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
 * Validates scoring vote payloads before any database mutation.
 */
final class vote_validator
{
	/**
	 * Validate a scoring vote payload.
	 *
	 * @param array $votes Submitted option => value map
	 * @param array $valid_option_ids Valid option IDs for the poll
	 * @param int   $max_per_option Maximum value per option
	 * @param int   $max_total Maximum total value
	 * @param bool  $can_change Whether existing votes may be reduced/removed
	 * @param array $current_votes Existing option => value map
	 * @return string|false Language key on failure, false on success
	 */
	public static function validate_scoring(array $votes, array $valid_option_ids, $max_per_option, $max_total, $can_change, array $current_votes)
	{
		if (!$votes)
		{
			return 'NO_VOTE_OPTION';
		}

		$valid_options = array_fill_keys(array_map('intval', $valid_option_ids), true);
		$total = 0;

		foreach ($votes as $option_id => $value)
		{
			$option_id = (int) $option_id;
			$value = (int) $value;

			if (!isset($valid_options[$option_id]))
			{
				return 'FORM_INVALID';
			}

			if ($value < 1 || $value > (int) $max_per_option)
			{
				return 'AP_VOTE_GREATER_THAN_MAXVALUE';
			}

			$total += $value;
			if ($total > (int) $max_total)
			{
				return 'AP_TOO_MANY_VOTES';
			}
		}

		if (!$can_change)
		{
			foreach ($current_votes as $option_id => $value)
			{
				if (!isset($votes[$option_id]) || (int) $votes[$option_id] < (int) $value)
				{
					return 'AP_VOTE_CHANGED';
				}
			}
		}

		return false;
	}
}
