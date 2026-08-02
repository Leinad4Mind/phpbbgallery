<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\pmmonitor\core;

class selection_parser
{
	const MAX_SELECTIONS = 100;

	public static function parse(array $values)
	{
		if (empty($values) || count($values) > self::MAX_SELECTIONS)
		{
			return false;
		}

		$selections = array();
		foreach ($values as $value)
		{
			if (!is_string($value) || !preg_match('/^([1-9][0-9]*):([1-9][0-9]*):(-?[0-9]+)$/D', $value, $match))
			{
				return false;
			}
			$selection = array(
				'msg_id' => (int) $match[1],
				'user_id' => (int) $match[2],
				'folder_id' => (int) $match[3],
			);
			if ($selection['folder_id'] < PRIVMSGS_HOLD_BOX)
			{
				return false;
			}
			$key = implode(':', $selection);
			$selections[$key] = $selection;
		}

		return array_values($selections);
	}
}
