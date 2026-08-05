<?php
/**
*
* @package Statistics
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\statistics\migrations\v32x;

/**
* Migration stage 2: dedicated a_statistics permission
*
* Previously gated behind acl_a_viewlogs, which let anyone with the narrow "view admin logs"
* permission read and delete the visitor log and search-engine config.
*/
class m2_permissions extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\forumhulp\statistics\migrations\v32x\m1_initial_schema');
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
			array('permission.add', array('a_statistics', true)),

			array('permission.permission_set', array('ADMINISTRATORS', 'a_statistics', 'group')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_statistics', 'role')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_statistics', 'role')),
		);
	}

	/**
	 * Revert changes
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function revert_data()
	{
		return array(
			array('permission.remove', array('a_statistics', true)),
		);
	}
}
