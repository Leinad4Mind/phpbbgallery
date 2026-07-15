<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use phpbb\db\migration\migration;

class m10_sort_rooms extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m9_prune_skip_rooms'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['permission.add', ['u_mchatrooms_sort', true]],
			['custom', [[$this, 'initial_sort_order']]],
		];
	}

	/**
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'mchat_rooms' => [
					'room_sort' => ['UINT', 0],
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
				$this->table_prefix . 'mchat_rooms' => [
					'room_sort',
				],
			],
		];
	}

	/**
	 *
	 */
	public function initial_sort_order()
	{
		$sql_array = [
			'SELECT'	=> 'mr.room_id',
			'FROM'		=> [$this->table_prefix . 'mchat_rooms' => 'mr'],
			'ORDER_BY'	=> 'LOWER(mr.room_name) ASC, mr.room_name ASC',
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		foreach ($rows as $i => $row)
		{
			$sql = 'UPDATE ' . $this->table_prefix . 'mchat_rooms
				SET room_sort = ' . ($i + 1) . '
				WHERE room_id = ' . (int) $row['room_id'];
			$this->db->sql_query($sql);
		}
	}
}
