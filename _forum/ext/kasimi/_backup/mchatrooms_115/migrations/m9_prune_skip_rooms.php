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

class m9_prune_skip_rooms extends migration
{
	static public function depends_on()
	{
		return array('\kasimi\mchatrooms\migrations\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('mchat_prune_skip_rooms', 0)),
		);
	}
}
