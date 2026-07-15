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

class m14_kick_permission extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m13_clean_sessions'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['permission.add', ['u_mchatrooms_kick', true]],
		];
	}
}
