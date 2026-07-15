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
	static public function depends_on()
	{
		return array('\kasimi\mchatrooms\migrations\m2_initial_data');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('mchat_invite_expiration', 15)),
			array('config.add', array('kasimi.mchatrooms.invite_id', 0)),
			array('permission.add', array('u_mchatrooms_invite', true)),
		);
	}
}
