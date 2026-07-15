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

class m7_room_index extends migration
{
	static public function depends_on()
	{
		return array('\kasimi\mchatrooms\migrations\m1_initial_schema');
	}

	public function update_schema()
	{
		return array(
			'add_index' => array(
				$this->table_prefix . 'mchat' => array(
					'idx_room_id' => array('room_id'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_keys' => array(
				$this->table_prefix . 'mchat' => array(
					'idx_room_id',
				),
			),
		);
	}
}
