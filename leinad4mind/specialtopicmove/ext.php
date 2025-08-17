<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialtopicmove;

use phpbb\extension\base;

class ext extends base
{
	const SPECIAL_TOPIC_MOVED_BIT_FIRST		= 0x01;
	const SPECIAL_TOPIC_MOVED_BIT_LAST		= 0x02;
	const SPECIAL_TOPIC_MOVED_BIT_MOVED		= 0x04;
	const SPECIAL_TOPIC_MOVED_BIT_SHADOW	= 0x08;

	/**
	 * @return bool
	 */
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.2.2', '>=') && phpbb_version_compare(PHP_VERSION, '5.4.7', '>=');
	}
}
