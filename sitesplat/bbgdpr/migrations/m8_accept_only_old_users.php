<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m8_accept_only_old_users extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('sitesplat_bbgdpr_accept_old_users');
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m7_privacy_policy_update_date');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_bbgdpr_accept_old_users', true)),
		);
	}
}
