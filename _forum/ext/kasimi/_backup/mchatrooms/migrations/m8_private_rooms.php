<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use kasimi\mchatrooms\core\constants;
use phpbb\db\migration\migration;

class m8_private_rooms extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m1_initial_schema'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_max_private_rooms', 10]],
			['permission.add', ['u_mchatrooms_create_private', true]],
		];
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mchat_rooms_users' => [
					'COLUMNS'		=> [
						'room_id'				=> ['UINT', null],
						'user_id'				=> ['UINT', null],
						'join_time'				=> ['TIMESTAMP', 0],
					],
					'KEYS'	=> [
						'unq'					=> ['UNIQUE', ['room_id', 'user_id']],
					],
				],
			],
			'add_columns' => [
				$this->table_prefix . 'mchat_rooms' => [
					'room_type'					=> ['TINT:4', constants::ROOM_TYPE_NORMAL],
					'room_owner_invite'			=> ['BOOL', 0],
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
			'drop_tables' => [
				$this->table_prefix . 'mchat_rooms_users',
			],
			'drop_columns' => [
				$this->table_prefix . 'mchat_rooms' => [
					'room_type',
					'room_owner_invite',
				],
			],
		];
	}
}
