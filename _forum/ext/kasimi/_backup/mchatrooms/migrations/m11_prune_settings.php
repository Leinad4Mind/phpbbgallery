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

class m11_prune_settings extends migration
{
	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\kasimi\mchatrooms\migrations\m10_sort_rooms'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['mchat_prune_skip_lobby', 0]],
			['config.add', ['mchat_prune_skip_public', $this->config['mchat_prune_skip_rooms']]],
			['config.add', ['mchat_prune_skip_protected', $this->config['mchat_prune_skip_rooms']]],
			['config.add', ['mchat_prune_skip_private', $this->config['mchat_prune_skip_rooms']]],
			['config.remove', ['mchat_prune_skip_rooms']],
		];
	}
}
