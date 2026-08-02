<?php
/**
 * @package User Defaults
 * @copyright (c) 2016 David Wood
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\userdefaults\migrations;

use phpbb\db\migration\migration;

class version_3_2_0 extends migration
{
	public static function depends_on()
	{
		return '\\david63\\userdefaults\\migrations\\version_2_1_0';
	}

	public function update_data()
	{
		return array(
			array('config.add', array('ud_type_forum_post', 0)),
			array('config.add', array('ud_moderation_queue', 0)),
			array('config.add', array('ud_type_pm_close', 0)),
			array('config.add', array('ud_type_pm_report', 0)),
			array('config.add', array('ud_type_report_close', 0)),
		);
	}
}
