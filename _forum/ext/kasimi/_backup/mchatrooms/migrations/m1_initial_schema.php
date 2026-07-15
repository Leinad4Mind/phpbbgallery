<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use kasimi\mchatrooms\core\constants;
use phpbb\db\migration\migration;

class m1_initial_schema extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v31x\v318rc1'];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'mchat_rooms' => [
					'COLUMNS'		=> [
						'room_id'				=> ['UINT', null, 'auto_increment'],
						'user_id'				=> ['UINT', 0],
						'room_name'				=> ['VCHAR:64', ''],
						'room_password'			=> ['VCHAR:64', ''],
					],
					'PRIMARY_KEY'				=> 'room_id',
				],

				$this->table_prefix . 'mchat_rooms_sessions' => [
					'COLUMNS'		=> [
						'session_id'			=> ['CHAR:32', ''],
						'session_user_id'		=> ['UINT', 0],
						'session_room_id'		=> ['UINT', 0],
					],
					'KEYS'	=> [
						'unq'					=> ['UNIQUE', ['session_id', 'session_user_id', 'session_room_id']],
					],
				],
			],

			'add_columns' => [
				$this->table_prefix . 'mchat' => [
					'room_id'					=> ['UINT', constants::LOBBY_ID],
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
				$this->table_prefix . 'mchat' => [
					'room_id',
				],
			],

			'drop_tables' => [
				$this->table_prefix . 'mchat_rooms',
				$this->table_prefix . 'mchat_rooms_sessions',
			],
		];
	}
}
