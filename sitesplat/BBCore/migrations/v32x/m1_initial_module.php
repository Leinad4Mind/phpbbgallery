<?php
/**
*
* @package sitesplat BBcore addon
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\migrations\v32x;

use phpbb\db\migration\container_aware_migration;

/**
* Migration stage 1: Initial data module
*/
class m1_initial_module extends container_aware_migration
{
	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_langname = 'UCP_IR'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');

		if (!$module_id)
		{
			return array(
				array('module.add', array(
					'ucp', 'UCP_PROFILE', array(
						'module_basename'	=> '\sitesplat\BBCore\ucp\ir_module',
						'modes'				=> array('ir'),
					),
				)),
			);
		} else
		{
			return array();
		}
	}

	public function revert_data()
	{
		if (!$this->container->get('ext.manager')->is_enabled('forumhulp/helper'))
		{
			return array(
				array('module.remove', array(
					'ucp',
					false,
					'UCP_IR',
				)),
			);	
		} else
		{
			return array(
				array('module.remove', array(
					'ucp',
					false,
					'UCP_IR',
				)),
				array('module.add', array(
					'ucp', 'UCP_PROFILE', array(
						'module_basename'	=> '\forumhulp\helper\ucp\ir_module',
						'modes'				=> array('ir'),
					),
				)),
			);	
		}
	}
}
