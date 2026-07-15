<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\migrations;

use kasimi\mchatrooms\core\constants;
use phpbb\db\migration\migration;

class m12_post_notifications extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m11_prune_settings'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_rooms_post_notifications', constants::LOBBY_ID]],
			['config.add', ['mchat_rooms_login_notifications', constants::LOBBY_ID]],
		];
	}
}
