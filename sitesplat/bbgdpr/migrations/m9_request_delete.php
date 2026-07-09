<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m9_request_delete extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('sitesplat_bbgdpr_request_delete');
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m8_accept_only_old_users');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_bbgdpr_request_delete', false)),
		);
	}
}
