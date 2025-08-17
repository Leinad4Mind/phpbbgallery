<?php
/**
*
* @package BBinfinitepagination
* @copyright (c) 2019 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbinfinitepagination\migrations;

class fx_config extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('sitesplat_bbinfinitepagination_fx');
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_data()
	{
		return [
			['config.add', ['sitesplat_bbinfinitepagination_fx', 'Hapi']],
			['config.add', ['sitesplat_bbinfinitepagination_viewtopic', '1']],
			['config.add', ['sitesplat_bbinfinitepagination_memberlist', '1']],
			['config.add', ['sitesplat_bbinfinitepagination_viewonline', '1']],
			['config.add', ['sitesplat_bbinfinitepagination_search', '1']],
			['config.add', ['sitesplat_bbinfinitepagination_viewforum', '1']],
		];
	}
}
