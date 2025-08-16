<?php
/**
*
* BBtags
*
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\migrations\v31x;

class m6_add_cloud_limit extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('sitesplat\bbtags\migrations\v31x\m5_read_permission');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('bbtags_cloud_limit', 10)),
		);
	}
}
