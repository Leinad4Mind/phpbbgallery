<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\migrations\v31x;

/**
 * Migration stage 2: Initial data
 */
class m2_initial_config extends \phpbb\db\migration\migration
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
		return array('\sitesplat\donations\migrations\v31x\m1_initial_schema');
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
			array('config.add', array('donations_options', '{"sandbox":"1","message":"1","list":"1"}')),
			array('config.add',	array('donations_paypal_email', '')),
			array('config.add',	array('donations_bitcoin', '{"key":"","secret":""}')),
			array('config.add',	array('donations_group_id', '{"time":"2","amount":"0","group":"2","default":0}')),
			array('config.add',	array('donations_amounts', '[{"amount":"10","symbol":"\\\f11c"},{"amount":"20","symbol":"\\\f121"},{"amount":"25","symbol":"\\\f102"},{"amount":"30","symbol":"\\\f124"},{"amount":"40","symbol":"\\\f135"},{"amount":"50","symbol":"\\\f12b"},{"amount":"100","symbol":"\\\f087"}]')),
			array('config.add',	array('donations_currency', 'USD')),
			array('config.add',	array('donations_fallbackgroup', 2)),
			array('config.add',	array('donations_gc', 86400)),
			array('config.add',	array('donations_last_gc', 0, 1)),
			array('config_text.add', array('donations_text', 'A %s donation to support our servers
Donate %s for free download
Premium account for only %s
Helps us getting better server for only %s
Upgrade to a better hardware and less maintenance for %s
Gets us a CDN so we can be faster and this for %s
Extra donations for this developer!')),
		);
	}
}
