<?php

/**
 *
 * @package phpBB Extension - mChat Icons Menu
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\mchaticonsmenu\migrations;

use phpbb\db\migration\migration;

class v1_1_0 extends migration
{
	public function update_data()
	{
		return [
			['config.add', ['mchat_iconsmenu_always', 1]],
			['permission.add', ['u_mchat_iconsmenu_always', true]],
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_mchat_iconsmenu_always' => ['BOOL', 1],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_mchat_iconsmenu_always',
				],
			],
		];
	}
}
