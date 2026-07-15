<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m7_privacy_policy_update_date extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('sitesplat_bbgdpr_privacy_update');
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m6_adsense');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_bbgdpr_privacy_update', '1527206400')),
		);
	}
}
