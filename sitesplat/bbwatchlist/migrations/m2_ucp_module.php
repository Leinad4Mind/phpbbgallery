<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbwatchlist\migrations;

class m2_ucp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'ucp'
				AND module_langname = 'UCP_SITESPLAT_BBWATCHLIST'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbwatchlist\migrations\m1_schema');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'ucp',
				'UCP_MAIN',
				'UCP_SITESPLAT_BBWATCHLIST'
			)),
			array('module.add', array(
				'ucp',
				'UCP_SITESPLAT_BBWATCHLIST',
				array(
					'module_basename'	=> '\sitesplat\bbwatchlist\ucp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
