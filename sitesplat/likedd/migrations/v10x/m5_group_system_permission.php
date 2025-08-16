<?php
/**
*
* phpBB Ajax likeBB.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\likedd\migrations\v10x;

/**
 * Migration stage 2: Initial data
 */
class m5_group_system_permission extends \phpbb\db\migration\migration
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
		return array('\sitesplat\likedd\migrations\v10x\m4_group_like_permission');
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	 
	// Set permissions - Global permissions that allows the use of the UCP module and top10 stats page
	// Permissions - User role - All Features - set to yes by default 
	public function update_data()
	{
		return array(
			// Add permission
			array('permission.add', array('u_likedd', 1, 0)),

			// Set permissions
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_likedd')),
		);
	}
}