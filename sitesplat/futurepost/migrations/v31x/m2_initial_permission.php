<?php
/**
*
* BBpostdated
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\futurepost\migrations\v31x;

/**
* Migration stage 1: Initial permission
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
		return array('\sitesplat\futurepost\migrations\v31x\m1_config_data');
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
			array('permission.add', array('u_futureposts', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_MOD_FULL', 'u_futureposts')),
		);
	}
}
