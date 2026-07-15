<?php

/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\grouprules\migrations;

use phpbb\db\migration\migration;

class m1_group_actions extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config_text.add', ['grouprules_group_actions', json_encode([])]],
		];
	}
}
