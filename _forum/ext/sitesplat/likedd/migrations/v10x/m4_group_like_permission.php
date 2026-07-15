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
		return array('\sitesplat\likedd\migrations\v10x\m3_initial_module');
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
			array('permission.add', array('u_likebb_like')),
			array('permission.add', array('u_likebb_dislike')),
            array('permission.permission_set', array('REGISTERED', 'u_likebb_like', 'group')),
            array('permission.permission_set', array('REGISTERED', 'u_likebb_dislike', 'group')),
		);
	}
}
