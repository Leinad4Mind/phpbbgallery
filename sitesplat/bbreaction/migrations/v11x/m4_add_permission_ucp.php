<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\migrations\v11x;

/**
* Migration stage 6: Initial module
*/
class m4_add_permission_ucp extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbreaction\migrations\v11x\m1_initial_permission');
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
		return array(
			// Add permission
			array('permission.add', array('u_bbreaction_module', 1, 0)),

			// Set permissions
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_bbreaction_module')),
		);
	}
}