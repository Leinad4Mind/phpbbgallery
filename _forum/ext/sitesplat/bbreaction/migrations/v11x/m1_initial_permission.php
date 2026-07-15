<?php
/**
*
* BB reaction.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\migrations\v11x;

/**
* Migration stage 1: Initial permission
*/
class m1_initial_permission extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbreaction\migrations\v10x\m1_initial_schema');
	}

	/**
	* Add or update data in the database
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			// Add permission
			array('permission.add', array('u_bbreaction', 1, 0)),

			// Set permissions
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_bbreaction')),
		);
	}
}
