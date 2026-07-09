<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m1_ucp extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'ucp'
				AND module_langname = 'UCP_DEMO_TITLE'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'ucp',
				0,
				'UCP_PRIVACY'
			)),
			array('module.add', array(
				'ucp',
				'UCP_PRIVACY',
				array(
					'module_basename'	=> '\sitesplat\bbgdpr\ucp\main_module',
					'modes'				=> array('review', 'download', 'delete'),
				),
			)),
		);
	}
}
