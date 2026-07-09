<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\migrations\v31x;

/**
 * Migration stage 3: Config data
 */
class m3_config_data extends \phpbb\db\migration\migration
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
		return array('\sitesplat\sidebar\migrations\v31x\m1_initial_schema');
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
		);
	}
}
