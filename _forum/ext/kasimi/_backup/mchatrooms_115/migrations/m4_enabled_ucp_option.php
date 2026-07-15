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
	public function update_data()
	{
		return array(
			array('config.add', array('mchat_rooms_enabled', 1)),
			array('permission.add', array('u_mchat_rooms_enabled', true)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_mchat_rooms_enabled' => array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_mchat_rooms_enabled',
				),
			),
		);
	}
}
