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
	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_max_invites', 10]],
		];
	}
}
