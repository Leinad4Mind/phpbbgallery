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
 * Migration stage 2: Initial data
 */
class m4_group_like_permission extends \phpbb\db\migration\migration
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
		return ['\sitesplat\likedd\migrations\v10x\m3_initial_module'];
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
			['permission.add', ['u_likebb_like']],
			['permission.add', ['u_likebb_dislike']],
			['if', [
				['permission.role_exists', ['REGISTERED']], // Check if REGISTERED exists before updating it
				['permission.permission_set', ['REGISTERED', 'u_likebb_like', 'group']], // Give REGISTERED u_likebb_like permission
				['permission.permission_set', ['REGISTERED', 'u_likebb_dislike', 'group']], // Give REGISTERED u_likebb_dislike permission
			]],
		];
	}
}