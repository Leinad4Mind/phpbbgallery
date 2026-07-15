<?php

/**
 *
 * phpBB Ajax likeBB.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\likedd\migrations\v10x;

/**
 * Migration stage 8: New config
 */
class m8_add_extra_config extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return ['\sitesplat\likedd\migrations\v10x\m7_add_another_index'];
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
			['config.add', ['sitesplat_likedd_button_position', 0]],
		];
	}
}