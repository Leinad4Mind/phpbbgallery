<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\migrations\v32x;

class m2_new_configs extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbfront\migrations\v32x\m1_initial_config');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_bbfront_grid_layout', '4-l')),
			array('config.add', array('sitesplat_bbfront_grid_fx_first', 'Hapi')),
			array('config.add', array('sitesplat_bbfront_grid_fx_load', 'Hapi')),
			array('config.add', array('sitesplat_bbfront_per_page_load', '5')),
			array('config.add', array('sitesplat_bbfront_infinite_scroll', false)),
			array('config_text.add', array('sitesplat_bbfront_ad_content', '')),
			array('config.add', array('sitesplat_bbfront_ad_frequency', '0')),
		);
	}
}
