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
 * Validates every page of a multi-question ballot against shared rules.
 */
final class multi_question_vote
{
	/**
	 * Whether an incremental ballot still has room for at least one new vote.
	 * Limits are evaluated independently for each question.
	 *
	 * @param array $questions Questions with id and option IDs
	 * @param array $current Current answers
	 * @param array $rules Shared poll rules
	 * @return bool
	 */
	public static function can_add_votes(array $questions, array $current, array $rules)
	{
		$type = (int) $rules['type'];
		$max_options = (int) $rules['max_options'];
		foreach ($questions as $question)
		{
			$question_id = (string) $question['id'];
			$votes = isset($current[$question_id]) && is_array($current[$question_id]) ? $current[$question_id] : array();
			$option_count = count($question['option_ids']);

			if ($type === poll_options::TYPE_RANKING)
			{
				if (!$votes && $option_count >= $max_options)
				{
					return true;
				}
				continue;
			}

			if ($type === poll_options::TYPE_SCORING)
			{
				$remaining = (int) $rules['total_value'] - array_sum($votes);
				if ($remaining <= 0)
				{
					continue;
				}
				foreach ($votes as $value)
				{
					if ((int) $value < (int) $rules['max_value'])
					{
						return true;
					}
				}
				if (count($votes) < min($max_options, $option_count) && $remaining >= (int) $rules['min_value'])
				{
					return true;
				}
				continue;
			}

			if (count($votes) < min($max_options, $option_count))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param array $questions Questions with id, required and option IDs
	 * @param array $answers Question ID => option ID => value
	 * @param array $rules Shared poll rules
	 * @param array $current Current answers
	 * @return array{answers:array,error:string|false}
	 */
	public static function validate(array $questions, array $answers, array $rules, array $current = array())
	{
		$normalised = array();
		$type = (int) $rules['type'];
		$vote_mode = (int) $rules['vote_mode'];
		$question_ids = array_fill_keys(array_map(function (array $question) {
			return (string) $question['id'];
		}, $questions), true);
		foreach (array_keys($answers) as $question_id)
		{
			if (!isset($question_ids[(string) $question_id]) || !is_array($answers[$question_id]))
			{
				return self::error('FORM_INVALID');
			}
		}
		$has_current = false;
		foreach ($current as $current_votes)
		{
			$has_current = $has_current || !empty($current_votes);
		}
		if ($has_current && $vote_mode === poll_options::VOTE_MODE_NO_CHANGE)
		{
			return self::error('AP_VOTE_CHANGED');
		}

		foreach ($questions as $question)
		{
			$question_id = (string) $question['id'];
			$submitted = isset($answers[$question_id]) && is_array($answers[$question_id])
				? $answers[$question_id]
				: array();
			$votes = array();
			$seen_options = array();
			foreach ($submitted as $option_id => $value)
			{
				$normalised_option_id = (int) $option_id;
				if (!is_int($value) || $value < 0 || isset($seen_options[$normalised_option_id]))
				{
					return self::error('FORM_INVALID');
				}
				$seen_options[$normalised_option_id] = true;
				$value = (int) $value;
				if ($value > 0)
				{
					$votes[$normalised_option_id] = $value;
				}
			}

			if (!$votes)
			{
				if ($vote_mode === poll_options::VOTE_MODE_INCREMENTAL && !empty($current[$question_id]))
				{
					return self::error('AP_VOTE_CHANGED');
				}
				if (!empty($question['required']))
				{
					return self::error('AP_REQUIRED_QUESTION_MISSING');
				}
				$normalised[$question_id] = array();
				continue;
			}

			$valid_ids = array_map('intval', $question['option_ids']);
			if ($type === poll_options::TYPE_RANKING)
			{
				$error = ranked_vote::validate_vote($votes, $valid_ids, $rules['rank_points'], $rules['max_options']);
			}
			else if ($type === poll_options::TYPE_SCORING)
			{
				$error = vote_validator::validate_scoring(
					$votes,
					$valid_ids,
					$rules['max_value'],
					$rules['total_value'],
					$vote_mode === poll_options::VOTE_MODE_CHANGE,
					isset($current[$question_id]) ? $current[$question_id] : array(),
					$rules['min_value']
				);
				if (!$error && count($votes) > (int) $rules['max_options'])
				{
					$error = 'TOO_MANY_VOTE_OPTIONS';
				}
			}
			else
			{
				$error = self::validate_choice($votes, $valid_ids, $rules['max_options']);
				if (!$error && $vote_mode === poll_options::VOTE_MODE_INCREMENTAL)
				{
					foreach (isset($current[$question_id]) ? $current[$question_id] : array() as $option_id => $value)
					{
						if (!isset($votes[$option_id]))
						{
							$error = 'AP_VOTE_CHANGED';
							break;
						}
					}
				}
			}

			if ($error)
			{
				return self::error($error);
			}
			$normalised[$question_id] = $votes;
		}

		return array('answers' => $normalised, 'error' => false);
	}

	private static function validate_choice(array $votes, array $valid_ids, $max_options)
	{
		if (count($votes) > (int) $max_options)
		{
			return 'TOO_MANY_VOTE_OPTIONS';
		}
		$valid = array_fill_keys($valid_ids, true);
		foreach ($votes as $option_id => $value)
		{
			if (!isset($valid[(int) $option_id]) || (int) $value !== 1)
			{
				return 'FORM_INVALID';
			}
		}
		return false;
	}

	private static function error($key)
	{
		return array('answers' => array(), 'error' => $key);
	}
}
