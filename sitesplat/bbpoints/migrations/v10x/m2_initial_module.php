<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\migrations\v10x;

/**
* Migration stage 2: Initial module
*/
class m2_initial_module extends \phpbb\db\migration\migration
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
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . ' WHERE module_langname = "ACP_MANAGE_FORUMS" AND module_basename = ""';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		
		return array(
			array('module.add', array(
				'acp', $row['module_id'], array(
					'module_basename'	=> '\sitesplat\bbpoints\acp\bbpoints_module',
					'auth'				=> 'ext_sitesplat/bbpoints && acl_a_board',
					'modes'				=> array('settings'),
				),
			)),
			array('module.add', array('ucp', 'UCP_PROFILE', 'BBPOINTS')),
			array('module.add', array(
				'ucp', 'BBPOINTS', array(
					'module_basename'	=> '\sitesplat\bbpoints\ucp\bbpoints_module',
					'auth'				=> 'ext_sitesplat/bbpoints',
					'modes'				=> array('bbpoints'),
				),
			)),
		);
	}
}
