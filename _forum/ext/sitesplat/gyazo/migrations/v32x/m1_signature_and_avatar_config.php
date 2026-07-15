<?php
/**
*
* Gyazo - forum images uploader
*
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\gyazo\migrations\v32x;

class m1_signature_and_avatar_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\gyazo\migrations\v31x\m1_initial_config');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('gyazo_signature', 1)),
			array('config.add', array('allow_avatar_gyazo', 1)),
		);
	}
}
