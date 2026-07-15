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

class m2_acp_module extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\leinad4mind\grouprules\migrations\m1_group_actions'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_GROUPS',
				[
					'module_basename'	=> '\leinad4mind\grouprules\acp\grouprules_module',
					'modes'				=> ['main'],
				],
			]],
		];
	}
}
