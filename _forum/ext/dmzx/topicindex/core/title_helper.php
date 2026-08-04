<?php
/**
 *
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\topicindex\core;

final class title_helper
{
	/**
	 * Remove at most two balanced leading title tags.
	 *
	 * @param string $title Topic title
	 * @param int $limit Maximum number of tags to remove
	 * @return string
	 */
	public function strip_leading_tags($title, $limit = 2)
	{
		$title = trim((string) $title);
		$pairs = [
			'(' => ')',
			'[' => ']',
			'{' => '}',
		];

		for ($removed = 0; $removed < (int) $limit; $removed++)
		{
			$opening = mb_substr($title, 0, 1);
			if (!isset($pairs[$opening]))
			{
				break;
			}

			$position = mb_strpos($title, $pairs[$opening], 1);
			if ($position === false)
			{
				break;
			}

			$title = ltrim(mb_substr($title, $position + 1));
		}

		return $title;
	}

	/**
	 * Build the legacy A-Z/0-9/symbol group and a stable Unicode sort key.
	 *
	 * @param string $title Topic title
	 * @param bool $strip_tags Whether leading tags should be ignored
	 * @return array
	 */
	public function get_keys($title, $strip_tags = false)
	{
		$sortable = $strip_tags ? $this->strip_leading_tags($title) : trim((string) $title);
		$clean = function_exists('utf8_clean_string') ? utf8_clean_string($sortable) : mb_strtolower($sortable);
		$clean = trim((string) $clean);
		$first = mb_substr($clean, 0, 1);

		if (preg_match('#^[a-z]$#', $first))
		{
			$group = $first;
		}
		else if (preg_match('#^[0-9]$#', $first))
		{
			$group = '09';
		}
		else
		{
			$group = '_';
		}

		return [
			'group' => $group,
			'sort' => mb_substr($clean, 0, 255),
		];
	}
}
