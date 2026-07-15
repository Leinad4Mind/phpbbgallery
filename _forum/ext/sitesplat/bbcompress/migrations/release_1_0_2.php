<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\migrations;

class release_1_0_2 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbcompress\migrations\release_1_0_0');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('kraken_api_key', '')),
			array('config.add', array('kraken_api_secret', '')),
		);
	}
}
