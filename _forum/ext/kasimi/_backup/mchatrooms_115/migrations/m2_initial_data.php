<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use phpbb\db\migration\container_aware_migration;

class m2_initial_data extends container_aware_migration
{
	static public function depends_on()
	{
		return array('\kasimi\mchatrooms\migrations\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			// Add config values
			array('config.add', array('mchat_max_rooms', 10)),

			// Add user permissions
			array('permission.add', array('u_mchatrooms_view', true)),
			array('permission.add', array('u_mchatrooms_create', true)),
			array('permission.add', array('u_mchatrooms_edit_own', true)),
			array('permission.add', array('u_mchatrooms_edit_all', true)),
			array('permission.add', array('u_mchatrooms_delete_own', true)),
			array('permission.add', array('u_mchatrooms_delete_all', true)),
			array('permission.add', array('u_mchatrooms_protected', true)),
			array('permission.add', array('u_mchatrooms_masterkey', true)),

			array('custom', array(array($this, 'insert_lobby'))),
		);
	}

	public function insert_lobby()
	{
		$user = $this->container->get('user');

		$sql_array = array(
			'room_name' => 'Lobby',
			'user_id'	=> $user->data['user_id'],
		);

		$sql = 'INSERT INTO ' . $this->table_prefix . 'mchat_rooms ' . $this->db->sql_build_array('INSERT', $sql_array);
		$this->db->sql_query($sql);
	}
}
