<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\migrations\v10x;

/**
* Migration stage 3: Initial config
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
		return array('\sitesplat\bbmembership\migrations\v10x\m2_initial_module');
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
			array('config.add', array('bbmembership_sandbox', 0)),
			array('config.add', array('bbmembership_clubmode', 0)),
			array('config.add', array('bbmembership_paypal_email', '')),
			array('config.add', array('bbmembership_currency', 'GBP')),
			array('config.add', array('bbmembership_bbpoints', 1)),
			array('config.add', array('bbmembership_groups', '{"3":{"group":0,"expire":180,"default":0,"hide":0,"new_user":1},"5":{"group":0,"expire":365,"default":0,"hide":0,"new_user":0},"30":{"group":0,"expire":30,"default":0,"hide":0,"new_user":1},"40":{"group":0,"expire":0,"default":0,"hide":0,"new_user":1}}')),
			array('config.add', array('bbmembership_package', '{"3":{"package":"Premium Download Access"},"5":{"package":"Premium Account Features"},"30":{"package":"Access to all the sections"},"40":{"package":"VIP rank and unlimited use"}}')),
			array('config.add', array('bbmembership_fallbackgroup', 1)),
			array('config.add', array('bbmembership_last_gc', 0, true)),
			array('config.add', array('bbmembership_gc', 86400))
		);
	}
}
