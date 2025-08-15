<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbrandom\migrations\v32x;

class m1_gravatar_style extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbrandom\migrations\v31x\m1_initial_config');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('default_rgravatar_style', 'identicon')),
		);
	}
}
