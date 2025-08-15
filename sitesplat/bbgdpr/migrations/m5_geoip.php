<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m5_geoip extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('sitesplat_bbgdpr_geoip');
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m4_deleted_count');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_bbgdpr_geoip', 0)),
		);
	}
}
