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
 * Migration stage 4: Add permission ucp
 */
class m4_add_permission_ucp extends migration
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
		return ['\sitesplat\bbreaction\migrations\v11x\m1_initial_permission'];
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */

	// Set permissions - Global permissions that allows the use of the UCP module and toplist stats page
	// Permissions - User role - All Features - set to yes by default 
	public function update_data()
	{
		return [
			// Add permission
			['permission.add', ['u_bbreaction_module', 1, 0]],

			// Set permissions
			['if', [
				['permission.role_exists', ['ROLE_USER_FULL']], // Check if ROLE_USER_FULL exists before updating it
				['permission.permission_set', ['ROLE_USER_FULL', 'u_bbreaction_module']], // Give ROLE_USER_FULL u_bbreaction_module permission
			]],
		];
	}
}