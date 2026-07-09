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
* Migration stage 4: Initial config
*/
class m3_initial_config extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbpoints\migrations\v10x\m2_initial_module');
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
			array('config.add', array('bbpoints_gc', 86400)),
			array('config.add', array('bbpoints_last_gc', 0, true)),
			array('config.add', array('bbpoints_settings', '{"ext_symbol":"fa-money","symbol_pos":1,"currency":"EUR","transfer_enable":0,"per_topic":20,"per_post":10,"per_word":1,"transfer_notify":0,"comments_enable":0,"bar_stats":1,"bbpoints_stats":1,"goal":1000,"per_login":5,"per_register":10,"per_birthday":5}')),
		);
	}
}
