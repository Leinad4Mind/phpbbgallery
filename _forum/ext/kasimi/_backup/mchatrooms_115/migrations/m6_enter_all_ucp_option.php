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
	public function update_data()
	{
		return array(
			array('config.add', array('mchat_rooms_enter_all', 0)),
			array('permission.add', array('u_mchat_rooms_enter_all', true)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_mchat_rooms_enter_all' => array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_mchat_rooms_enter_all',
				),
			),
		);
	}
}
