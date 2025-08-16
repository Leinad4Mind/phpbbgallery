<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\migrations\v32x;

/**
* Migration stage 3: Initial permission
*/
class m5_initial_permission extends \phpbb\db\migration\migration
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
//		return array('\phpbb\db\migration\data\v310\gold');
		return array('\sitesplat\bbtags\migrations\v31x\m4_initial_module');
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
			array('permission.add', array('u_bbtags_read', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_bbtags_read')),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 'u_bbtags_read')),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_bbtags_read')),
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_bbtags_read')),
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_bbtags_read')),
			array('permission.permission_set', array('ROLE_USER_NEW_MEMBER', 'u_bbtags_read')),
		);
	}
}