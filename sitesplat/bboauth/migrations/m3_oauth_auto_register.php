<?php
/**
*
* BBOAuth
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bboauth\migrations;

class m3_oauth_auto_register extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('sitesplat_bboauth_autoregistration');
	}

	static public function depends_on()
	{
		return ['\sitesplat\bboauth\migrations\m1_add_login_type_to_users'];
	}

	public function update_data()
	{
		return [
			['config.add', ['sitesplat_bboauth_autoregistration', false]],
		];
	}
}
