<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\migrations;

class install_sidebar extends \phpbb\db\migration\migration
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
		return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
	}

	/**
	 * Add the sidebar table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'sidebar_types'	=> array(
					'COLUMNS'		=> array(
						'sidebar_type_id'	=> array('USINT', null, 'auto_increment'),
						'sidebar_type_name'	=> array('VCHAR:255', ''),
						'sidebar_options'	=> array('VCHAR:2', '00')
					),
					'PRIMARY_KEY'	=> array('sidebar_type_id'),
					'KEYS'			=> array(
						'type'		=> array('UNIQUE', array('sidebar_type_name')),
					),
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sidebar_settings', '{"type":false,"width":1,"height":false,"all_pages":false,"shuffle":true,"slots":3,"how_many":5,"ignore_inactive_users":false,"ignore_founder":true,"ignore_admins_mods":true}')),

			array('config.add', array('sidebar_slot1_active', 0)),
			array('config.add', array('sidebar_slot2_active', 0)),
			array('config.add', array('sidebar_slot3_active', 0)),

			array('config.add', array('sidebar_slot1_title', '')),
			array('config.add', array('sidebar_slot2_title', '')),
			array('config.add', array('sidebar_slot3_title', '')),
			
			array('config_text.add', array('sidebar_slot1_text', '')),
			array('config_text.add', array('sidebar_slot2_text', '')),
			array('config_text.add', array('sidebar_slot3_text', '')),
			
			array('custom', array(array($this, 'set_autoincrement'))),

			array('module.add', array(
				'acp',
				'ACP_QUICK_ACCESS',
				array(
					'module_basename'	=> '\sitesplat\sidebar\acp\sidebar_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
	
	/**
	 * Drop the sidebar table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'sidebar_types',
			),
		);
	}

	/**
	 * Alter autoincrement to table in database
	 *
	 * @return null
	 * @access public
	 */
	public function set_autoincrement()
	{
		$sql = 'ALTER TABLE ' . $this->table_prefix . 'sidebar_types' . ' AUTO_INCREMENT = 10';
		$this->db->sql_query($sql);		
	}
}