<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\migrations\v32x;

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
		return array('\sitesplat\sidebar\migrations\v31x\m3_config_data');
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
			array('custom', array(array($this, 'update_config'))),
		);
	}

	/**
	 * Alter the database
	 *
	 * @return null
	 * @access public
	 */
	public function update_config()
	{
		$sidebar_config = json_decode($this->config['sidebar_settings'], true);
		$sidebar_config['panel_pages'] = 0;
		$this->config->set('sidebar_settings', json_encode($sidebar_config));
	}
}
