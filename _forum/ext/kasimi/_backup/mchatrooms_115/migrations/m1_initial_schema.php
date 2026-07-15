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
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v318rc1');
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'mchat_rooms' => array(
					'COLUMNS'		=> array(
						'room_id'				=> array('UINT', null, 'auto_increment'),
						'user_id'				=> array('UINT', 0),
						'room_name'				=> array('VCHAR:64', ''),
						'room_password'			=> array('VCHAR:64', ''),
					),
					'PRIMARY_KEY'				=> 'room_id',
				),

				$this->table_prefix . 'mchat_rooms_sessions' => array(
					'COLUMNS'		=> array(
						'session_id'			=> array('CHAR:32', ''),
						'session_user_id'		=> array('UINT', 0),
						'session_room_id'		=> array('UINT', 0),
					),
					'KEYS'	=> array(
						'unq'					=> array('UNIQUE', array('session_id', 'session_user_id', 'session_room_id')),
					),
				),
			),

			'add_columns' => array(
				$this->table_prefix . 'mchat' => array(
					'room_id'					=> array('UINT', constants::LOBBY_ID),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'mchat' => array(
					'room_id',
				),
			),

			'drop_tables' => array(
				$this->table_prefix . 'mchat_rooms',
				$this->table_prefix . 'mchat_rooms_sessions',
			),
		);
	}
}
