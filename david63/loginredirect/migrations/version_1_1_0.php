<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2014 David Wood
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\loginredirect\migrations;

use phpbb\db\migration\migration;

class version_1_1_0 extends migration
{
	public static function depends_on()
	{
		return '\\david63\\loginredirect\\migrations\\version_1_0_0';
	}

	public function update_data()
	{
		return array(
			array('config.add', array('loginredirect_announce_priority', 1)),
			array('config.add', array('loginredirect_announce_topic_id', 0)),
			array('config.add', array('loginredirect_any_announce', 0)),
		);
	}
}
