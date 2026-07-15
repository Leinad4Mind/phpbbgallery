<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use phpbb\db\migration\container_aware_migration;

class m13_clean_sessions extends container_aware_migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m12_post_notifications', '\kasimi\mchatrooms\migrations\m8_private_rooms'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['custom', [[$this, 'clean_sessions']]],
		];
	}

	/**
	 *
	 */
	public function clean_sessions()
	{
		$sql = 'SELECT user_id
			FROM ' . USERS_TABLE;

		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$user_ids = [];

		foreach ($rows as $row)
		{
			$user_ids[] = $row['user_id'];
		}

		if ($user_ids)
		{
			$sql = 'DELETE FROM ' . $this->table_prefix . 'mchat_rooms_sessions
				WHERE ' . $this->db->sql_in_set('session_user_id', $user_ids, true);
			$this->db->sql_query($sql);

			$sql = 'DELETE FROM ' . $this->table_prefix . 'mchat_rooms_users
				WHERE ' . $this->db->sql_in_set('user_id', $user_ids, true);
			$this->db->sql_query($sql);
		}
	}
}
