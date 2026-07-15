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
	public function update_schema()
	{
		return [
			'add_index' => [
				$this->table_prefix . 'mchat' => [
					'idx_room_id' => ['room_id'],
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
			'drop_keys' => [
				$this->table_prefix . 'mchat' => [
					'idx_room_id',
				],
			],
		];
	}
}
