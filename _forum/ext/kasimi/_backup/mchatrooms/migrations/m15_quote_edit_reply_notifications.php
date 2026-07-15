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

class m15_quote_edit_reply_notifications extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m14_kick_permission'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_rooms_quote_notifications', $this->config['mchat_rooms_post_notifications']]],
			['config.add', ['mchat_rooms_edit_notifications', $this->config['mchat_rooms_post_notifications']]],
			['config.add', ['mchat_rooms_reply_notifications', $this->config['mchat_rooms_post_notifications']]],
		];
	}
}
