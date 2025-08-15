<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\migrations\v31x;

class m3_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbfront\migrations\v31x\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('bbfront_inc_forums', '[]')),
			array('config.add', array('bbfront_inc_groups', '[]')),
			array('config.add', array('bbfront_settings', '{"name":"News","chars":"380", "use_avatar":"1"}'))
		);
	}
}
