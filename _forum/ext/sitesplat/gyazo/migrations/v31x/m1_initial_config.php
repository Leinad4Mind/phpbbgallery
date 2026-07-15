<?php
/**
*
* Gyazo - forum images uploader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\gyazo\migrations\v31x;

class m1_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('gyazo_clientid', '')),
		);
	}
}
