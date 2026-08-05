<?php
/**
*
* @package PostsStatistics
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\postsstats\migrations\v31x;

/**
* Migration stage 4: dedicated a_postsstats permission
*
* Previously gated behind acl_a_viewlogs, which let anyone with the narrow
* "view admin logs" permission reach the configuration screen, including the
* SQL injection that lived there before this migration's sibling fixes.
*/
class m4_permissions extends \phpbb\db\migration\migration
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
		return array('\forumhulp\postsstats\migrations\v31x\m3_initial_module');
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
			array('permission.add', array('a_postsstats', true)),

			array('permission.permission_set', array('ADMINISTRATORS', 'a_postsstats', 'group')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_postsstats', 'role')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_postsstats', 'role')),
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
			array('permission.remove', array('a_postsstats', true)),
		);
	}
}
