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
	static public function depends_on()
	{
		return array('\kasimi\mchatrooms\migrations\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('mchat_max_private_rooms', 10)),
			array('permission.add', array('u_mchatrooms_create_private', true)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'mchat_rooms_users' => array(
					'COLUMNS'		=> array(
						'room_id'				=> array('UINT', null),
						'user_id'				=> array('UINT', null),
						'join_time'				=> array('TIMESTAMP', 0),
					),
					'KEYS'	=> array(
						'unq'					=> array('UNIQUE', array('room_id', 'user_id')),
					),
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'mchat_rooms' => array(
					'room_type'					=> array('TINT:4', constants::ROOM_TYPE_NORMAL),
					'room_owner_invite'			=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'mchat_rooms_users',
			),
			'drop_columns' => array(
				$this->table_prefix . 'mchat_rooms' => array(
					'room_type',
					'room_owner_invite',
				),
			),
		);
	}
}
