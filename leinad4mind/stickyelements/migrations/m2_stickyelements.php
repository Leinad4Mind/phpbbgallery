<?php

/**
 *
 * Sticky Elements. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\stickyelements\migrations;

use leinad4mind\stickyelements\includes\helper;

class m2_stickyelements extends \phpbb\db\migration\migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\leinad4mind\stickyelements\migrations\m1_acp_module'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config_text.add', ['sticky_buttons', helper::get_empty_stickyelements()]],
		];
	}
}
