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
 * Parses additional question definitions that share the topic poll rules.
 */
final class multi_question_payload
{
	const MAX_QUESTIONS = 20;
	const MAX_OPTIONS = 100;
	const MAX_PAYLOAD_BYTES = 1048576;

	/**
	 * Decode and normalise posting JSON.
	 *
	 * @param string $json Submitted JSON
	 * @param int    $minimum_options Minimum options required by global rules
	 * @return array{questions:array,error:string|false}
	 */
	public static function decode($json, $minimum_options = 2)
	{
		if ($json === '')
		{
			return array('questions' => array(), 'error' => false);
		}

		if (strlen($json) > self::MAX_PAYLOAD_BYTES)
		{
			return self::error('AP_MULTI_TOO_MANY');
		}

		$decoded = json_decode($json, true);
		if (!is_array($decoded) || json_last_error() !== JSON_ERROR_NONE)
		{
			return self::error('AP_MULTI_INVALID');
		}
		if ($decoded && array_keys($decoded) !== range(0, count($decoded) - 1))
		{
			return self::error('AP_MULTI_INVALID');
		}
		if (count($decoded) > self::MAX_QUESTIONS)
		{
			return self::error('AP_MULTI_TOO_MANY');
		}

		$questions = array();
		$question_ids = array();
		foreach ($decoded as $index => $question)
		{
			$normalised = self::normalise_question($question, $index, $minimum_options);
			if ($normalised['error'])
			{
				return self::error($normalised['error']);
			}
			$question_id = (int) $normalised['question']['id'];
			if ($question_id && isset($question_ids[$question_id]))
			{
				return self::error('AP_MULTI_INVALID');
			}
			$question_ids[$question_id] = true;
			$questions[] = $normalised['question'];
		}

		return array('questions' => $questions, 'error' => false);
	}

	/**
	 * Validate one additional question.
	 *
	 * @param mixed $question Submitted question
	 * @param int   $index Question order
	 * @param int   $minimum_options Minimum options required by global rules
	 * @return array
	 */
	private static function normalise_question($question, $index, $minimum_options)
	{
		if (!is_array($question))
		{
			return array('question' => array(), 'error' => 'AP_MULTI_INVALID');
		}

		if (!array_key_exists('text', $question) || !is_string($question['text'])
			|| (array_key_exists('id', $question) && (!is_int($question['id']) || $question['id'] < 0))
			|| (array_key_exists('required', $question) && !is_bool($question['required'])))
		{
			return array('question' => array(), 'error' => 'AP_MULTI_INVALID');
		}
		$text = trim($question['text']);
		$options = array();
		$submitted_options = isset($question['options']) && is_array($question['options']) ? $question['options'] : array();
		if ($submitted_options && array_keys($submitted_options) !== range(0, count($submitted_options) - 1))
		{
			return array('question' => array(), 'error' => 'AP_MULTI_INVALID');
		}
		$option_ids = array();
		foreach ($submitted_options as $option)
		{
			if (is_string($option))
			{
				$option_text = trim($option);
				$option_id = 0;
			}
			else if (is_array($option) && array_key_exists('text', $option) && is_string($option['text'])
				&& (!array_key_exists('id', $option) || (is_int($option['id']) && $option['id'] >= 0)))
			{
				$option_text = trim($option['text']);
				$option_id = isset($option['id']) ? $option['id'] : 0;
			}
			else
			{
				return array('question' => array(), 'error' => 'AP_MULTI_INVALID');
			}
			if ($option_text !== '')
			{
				if ($option_id && isset($option_ids[$option_id]))
				{
					return array('question' => array(), 'error' => 'AP_MULTI_INVALID');
				}
				$option_ids[$option_id] = true;
				$options[] = array(
					'id' => $option_id,
					'text' => mb_substr($option_text, 0, 255, 'UTF-8'),
				);
			}
		}

		$minimum_options = max(2, (int) $minimum_options);
		if ($text === '' || mb_strlen($text, 'UTF-8') > 255 || count($options) < $minimum_options || count($options) > self::MAX_OPTIONS)
		{
			return array('question' => array(), 'error' => 'AP_MULTI_CONTENT_INVALID');
		}

		return array(
			'question' => array(
				'id' => isset($question['id']) ? max(0, (int) $question['id']) : 0,
				'order' => $index + 2,
				'text' => mb_substr($text, 0, 255, 'UTF-8'),
				'required' => !empty($question['required']),
				'options' => $options,
			),
			'error' => false,
		);
	}

	/**
	 * Build an error result.
	 *
	 * @param string $key Language key
	 * @return array
	 */
	private static function error($key)
	{
		return array('questions' => array(), 'error' => $key);
	}
}
