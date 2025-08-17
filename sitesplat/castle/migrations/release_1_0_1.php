<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\castle\migrations;

class release_1_0_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\castle\migrations\release_1_0_0');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('castle_feedback_redirect_configured', 0)),
		);
	}
}
