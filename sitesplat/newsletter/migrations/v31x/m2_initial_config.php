<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\migrations\v31x;

class m2_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\newsletter\migrations\v31x\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('newsletter_gc', 604800, true)),
			array('config.add', array('newsletter_last_gc', (time() - 604800), true)),
			array('config.add', array('newsletter_settings', '{"group":"2","usernames":"","period":"0","priority":"2","immediately":"0","newuser":"0","use_html":"0"}'))
		);
	}
}
