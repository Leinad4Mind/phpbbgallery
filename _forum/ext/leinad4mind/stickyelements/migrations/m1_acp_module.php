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

use phpbb\db\migration\migration;

class m1_acp_module extends migration
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
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_STICKYELEMENTS_TITLE',
			]],
			['module.add', [
				'acp',
				'ACP_STICKYELEMENTS_TITLE',
				[
					'module_basename'	=> '\leinad4mind\stickyelements\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],
		];
	}
}
