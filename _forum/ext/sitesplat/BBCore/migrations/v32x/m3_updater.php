<?php
/**
*
* @package sitesplat BBcore addon
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\migrations\v32x;

class m3_updater extends \phpbb\db\migration\container_aware_migration
{
	public function effectively_installed()
	{
		return $this->container->get('config_text')->get('sitesplat_bbcore_minify_html') !== null;
	}

	static public function depends_on()
	{
		return array('\sitesplat\BBCore\migrations\v32x\m2_minify_option');
	}

	public function update_data()
	{
		return [
			['config_text.add', ['sitesplat_bbcore_updater', '']],
		];
	}
}
