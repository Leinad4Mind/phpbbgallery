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

class m5_max_invites extends migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('mchat_max_invites', 10)),
		);
	}
}
