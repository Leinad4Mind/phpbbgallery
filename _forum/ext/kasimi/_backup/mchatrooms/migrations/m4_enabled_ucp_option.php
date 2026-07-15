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

class m4_enabled_ucp_option extends migration
{
	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_rooms_enabled', 1]],
			['permission.add', ['u_mchat_rooms_enabled', true]],
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
					'user_mchat_rooms_enabled' => ['BOOL', 1],
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
					'user_mchat_rooms_enabled',
				],
			],
		];
	}
}
