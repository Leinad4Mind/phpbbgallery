<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\migrations\v32x;

class m1_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\newsletter\migrations\v31x\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('newsletter_forums', '[]'))
		);
	}
}
