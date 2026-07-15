<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use phpbb\db\migration\container_aware_migration;

class m3_invite extends container_aware_migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m2_initial_data'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_invite_expiration', 15]],
			['config.add', ['kasimi.mchatrooms.invite_id', 0]],
			['permission.add', ['u_mchatrooms_invite', true]],
		];
	}
}
