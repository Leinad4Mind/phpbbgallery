<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbadblock\migrations\v10x;

use phpbb\db\migration\container_aware_migration;

/**
* Migration stage 4: Initial config
*/
class m3_initial_config extends container_aware_migration
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
		return array('\sitesplat\bbadblock\migrations\v10x\m2_initial_module');
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
			array('config.add', array('bbadblock_classname', 'ad_postbody')),
			array('config.add', array('bbadblock_message', 'You are using an ADblock therefore posts are hidden by our BBadblock protection by sitesplat.com')),
			array('config.add', array('bbadblock_redirect', ($this->container->get('ext.manager')->is_enabled('sitesplat/bbmembership') ? preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', $this->container->get('controller.helper')->route('sitesplat_bbmembership_main_controller', array())): ''))),
			array('config.add', array('bbadblock_autoreset', 0)),
			array('config.add', array('bbadblock_hide_forums', '[]')),
			array('config.add', array('bbadblock_modal_alert', 1)),
			array('config.add', array('bbadblock_group', 0)),
		);
	}
}
