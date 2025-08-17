<?php
/**
*
* UserDefaults extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\userdefault\migrations\v31x;

use phpbb\db\migration\container_aware_migration;

/**
* Migration stage 2: Initial module
*/
class m2_initial_module extends container_aware_migration
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
		return array('\forumhulp\userdefault\migrations\v31x\m1_initial_data');
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
			array('module.add', array(
				'acp', 'ACP_BOARD_CONFIGURATION', array(
					'module_basename'	=> '\forumhulp\userdefault\acp\userdefault_module',
					'modes'				=> array('settings'),
				),
			)),
			array('custom', array(array($this, 'move_module'))),
		);
	}

	public function move_module()
	{
		$sql = 'SELECT *, (right_id - (SELECT right_id FROM ' . MODULES_TABLE . ' WHERE module_langname = "ACP_REGISTER_SETTINGS")) / 2 AS steps 
				FROM ' . MODULES_TABLE . ' WHERE module_langname = "ACP_USERDEFAULT"';
		$result = $this->db->sql_query($sql);
		$module_row = $this->db->sql_fetchrow();
		
		if (version_compare($this->config['version'], '3.2.*', '<'))
		{
			$module_manager = $this->container->get('forumhulp.helper');
			$module_manager->move_module_by($module_row, 'acp', 'move_up', (int) $module_row['steps']);	
		} else
		{
			$module_manager = $this->container->get('module.manager');
			$module_manager->move_module_by($module_row, 'acp', 'move_up', (int) $module_row['steps']);	
		}
	}
}
