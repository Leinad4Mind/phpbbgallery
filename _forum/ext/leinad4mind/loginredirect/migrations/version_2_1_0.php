<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2014 David Wood
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\loginredirect\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public static function depends_on()
	{
		return '\\leinad4mind\\loginredirect\\migrations\\version_1_1_0';
	}

	public function update_data()
	{
		return array(
			array('config.add', array('loginredirect_always', 0)),
			array('config.add', array('loginredirect_global', 0)),
		);
	}
}
