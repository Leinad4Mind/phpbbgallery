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
			// Add config values
			['config.add', ['mchat_max_rooms', 10]],

			// Add user permissions
			['permission.add', ['u_mchatrooms_view', true]],
			['permission.add', ['u_mchatrooms_create', true]],
			['permission.add', ['u_mchatrooms_edit_own', true]],
			['permission.add', ['u_mchatrooms_edit_all', true]],
			['permission.add', ['u_mchatrooms_delete_own', true]],
			['permission.add', ['u_mchatrooms_delete_all', true]],
			['permission.add', ['u_mchatrooms_protected', true]],
			['permission.add', ['u_mchatrooms_masterkey', true]],

			['custom', [[$this, 'insert_lobby']]],
		];
	}

	public function insert_lobby()
	{
		$user = $this->container->get('user');

		$sql_array = [
			'room_name' => 'Lobby',
			'user_id'	=> $user->data['user_id'],
		];

		$sql = 'INSERT INTO ' . $this->table_prefix . 'mchat_rooms ' . $this->db->sql_build_array('INSERT', $sql_array);
		$this->db->sql_query($sql);
	}
}
