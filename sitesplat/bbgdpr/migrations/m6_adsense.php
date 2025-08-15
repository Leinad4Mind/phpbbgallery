<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m6_adsense extends \phpbb\db\migration\container_aware_migration
{
	public function effectively_installed()
	{
		return $this->container->get('config_text')->get('sitesplat_bbgdpr_adsense') !== null;
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m5_geoip');
	}

	public function update_data()
	{
		return array(
			array('config_text.add', array('sitesplat_bbgdpr_adsense', '')),
		);
	}
}
