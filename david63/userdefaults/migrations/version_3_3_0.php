<?php
/**
 * @package User Defaults
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\userdefaults\migrations;

use phpbb\db\migration\migration;

class version_3_3_0 extends migration
{
	public static function depends_on()
	{
		return '\\david63\\userdefaults\\migrations\\version_3_2_0';
	}

	public function update_data()
	{
		return array(
			array('config.remove', array('ud_allow_viewonline')),
			array('config.remove', array('ud_notifications')),
		);
	}
}
