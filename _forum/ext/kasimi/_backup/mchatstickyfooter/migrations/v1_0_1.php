<?php

/**
 *
 * @package phpBB Extension - mChat Sticky Footer
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatstickyfooter\migrations;

use phpbb\db\migration\migration;

class v1_0_1 extends migration
{
	public static function depends_on()
	{
		return ['\kasimi\mchatstickyfooter\migrations\v1_0_0'];
	}

	public function update_data()
	{
		return [
			['config.add', ['mchat_sticky_footer', 0]],
		];
	}
}
