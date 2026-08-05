<?php
/**
*
* @package PM SPy
* @copyright (c) 2016 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\pmspy\migrations\v31x;

/**
* Migration stage 2: dedicated a_pmspy permission
*
* Previously gated behind acl_a_viewlogs, which let anyone with the narrow
* "view admin logs" permission read and delete every member's private
* messages. Introduces its own permission instead.
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
		return array('\forumhulp\pmspy\migrations\v31x\m1_initial_module');
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
			array('permission.add', array('a_pmspy', true)),

			array('permission.permission_set', array('ADMINISTRATORS', 'a_pmspy', 'group')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_pmspy', 'role')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_pmspy', 'role')),
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
			array('permission.remove', array('a_pmspy', true)),
		);
	}
}
