<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use phpbb\db\migration\migration;

class m6_enter_all_ucp_option extends migration
{
	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_rooms_enter_all', 0]],
			['permission.add', ['u_mchat_rooms_enter_all', true]],
		];
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_mchat_rooms_enter_all' => ['BOOL', 0],
				],
			],
		];
	}

	/**
	 * @return array
	 */
	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_mchat_rooms_enter_all',
				],
			],
		];
	}
}
