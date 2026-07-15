<?php

/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\migrations\v11x;

/**
 * Migration stage 2: Initial permission
 */
class m2_initial_permission extends \phpbb\db\migration\migration
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
		return ['\sitesplat\bbpoints\migrations\v10x\m1_initial_schema'];
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
			['permission.add', ['f_hide_topic', 0, 1]],
			['permission.add', ['u_bbpoints_override', true]],

			// Set permissions
			['if', [
				['permission.role_exists', ['ROLE_FORUM_FULL']], // Check if ROLE_FORUM_FULL exists before updating it
				['permission.permission_set', ['ROLE_FORUM_FULL', 'f_hide_topic']], // Give ROLE_FORUM_FULL f_hide_topic permission
			]],

		];
	}
}