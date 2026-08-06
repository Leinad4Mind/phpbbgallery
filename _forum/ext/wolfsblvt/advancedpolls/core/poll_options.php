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
 * Stable values and policy helpers for poll visibility and vote changes.
 */
final class poll_options
{
	const VISIBILITY_PUBLIC = 0;
	const VISIBILITY_DEFAULT = 1;
	const VISIBILITY_VOTE_COMPLETED = 2;
	const VISIBILITY_PRIVATE = 3;

	const VOTE_MODE_NO_CHANGE = 0;
	const VOTE_MODE_INCREMENTAL = 1;
	const VOTE_MODE_CHANGE = 2;

	/**
	 * Whether a visibility value is supported.
	 *
	 * @param int $visibility Visibility value
	 * @return bool
	 */
	public static function is_valid_visibility($visibility)
	{
		return in_array((int) $visibility, array(
			self::VISIBILITY_PUBLIC,
			self::VISIBILITY_DEFAULT,
			self::VISIBILITY_VOTE_COMPLETED,
			self::VISIBILITY_PRIVATE,
		), true);
	}

	/**
	 * Whether a vote mode value is supported.
	 *
	 * @param int $mode Vote mode
	 * @return bool
	 */
	public static function is_valid_vote_mode($mode)
	{
		return in_array((int) $mode, array(
			self::VOTE_MODE_NO_CHANGE,
			self::VOTE_MODE_INCREMENTAL,
			self::VOTE_MODE_CHANGE,
		), true);
	}

	/**
	 * Decide whether results must be hidden for the current viewer.
	 *
	 * @param int  $visibility Visibility mode
	 * @param bool $poll_ended Poll has ended
	 * @param bool $has_voted Viewer submitted at least one vote
	 * @param bool $vote_completed Viewer used all available votes
	 * @param bool $force_display Moderator override
	 * @return bool
	 */
	public static function results_are_hidden($visibility, $poll_ended, $has_voted, $vote_completed, $force_display = false)
	{
		if ($force_display || $poll_ended)
		{
			return false;
		}

		switch ((int) $visibility)
		{
			case self::VISIBILITY_PUBLIC:
				return false;

			case self::VISIBILITY_DEFAULT:
				return !$has_voted;

			case self::VISIBILITY_VOTE_COMPLETED:
				return !$vote_completed;

			case self::VISIBILITY_PRIVATE:
			default:
				return true;
		}
	}
}
