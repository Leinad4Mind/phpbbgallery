<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\migrations\v11x;

use \phpbb\db\migration\migration;

/**
 * Migration stage 1: Initial permission
 */
class m1_initial_permission extends migration
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
		return ['\sitesplat\bbreaction\migrations\v10x\m1_initial_schema'];
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
			// Add permission
			['permission.add', ['u_bbreaction', 1, 0]],

			// Set permissions
			['if', [
				['permission.role_exists', ['ROLE_USER_FULL']], // Check if ROLE_USER_FULL exists before updating it
				['permission.permission_set', ['ROLE_USER_FULL', 'u_bbreaction']], // Give ROLE_USER_FULL u_bbreaction permission
			]],
		];
	}
}