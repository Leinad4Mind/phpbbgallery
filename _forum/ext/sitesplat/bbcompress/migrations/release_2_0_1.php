<?php
/**
*
* BBcompress
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\migrations;

class release_2_0_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbcompress\migrations\release_1_0_2');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('tinify_resize', '')),
			array('config.add', array('tinify_width', 0)),
			array('config.add', array('tinify_height', 0)),
		);
	}
}
