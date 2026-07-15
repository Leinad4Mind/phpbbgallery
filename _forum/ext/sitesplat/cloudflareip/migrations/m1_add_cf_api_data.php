<?php
/**
*
* Cloudflare IP
*
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\cloudflareip\migrations;

/**
 * Migration stage 3: Config data
 */
class m1_add_cf_api_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v3110');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_cf_email', '')),
			array('config.add', array('sitesplat_cf_api_key', '')),
			array('config.add', array('sitesplat_cf_domain', '')),
		);
	}
}