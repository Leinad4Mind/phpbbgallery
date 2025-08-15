<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
		return array('\sitesplat\bbpoints\migrations\v10x\m1_initial_schema');
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
			array('permission.add', array('f_hide_topic', 0, 1)),
			array('permission.add', array('u_bbpoints_override', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_hide_topic')),
		);
	}
}
