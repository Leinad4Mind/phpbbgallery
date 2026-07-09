<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\migrations;

class m4_link_new_window extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bblinks\migrations\m3_localurltotext');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('bblinks_cpf_link_new_window', 0)),
			array('config.add', array('bblinks_signature', 0)),
		);
	}
}
