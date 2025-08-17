<?php
/**
 *
 * @package User Defaults Extension
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\userdefaults\migrations;

use phpbb\db\migration\migration;

class version_3_2_0 extends migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	public static function depends_on()
	{
		return ['\david63\userdefaults\migrations\version_2_1_0'];
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return [
			['config.add', ['ud_type_forum_post', 0]],
			['config.add', ['ud_moderation_queue', 0]],
			['config.add', ['ud_type_pm_close', 0]],
			['config.add', ['ud_type_pm_report', 0]],
			['config.add', ['ud_type_report_close', 0]],
		];
	}
}
