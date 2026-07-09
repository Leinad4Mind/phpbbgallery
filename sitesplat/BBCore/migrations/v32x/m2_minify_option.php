<?php
/**
*
* @package sitesplat BBcore addon
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\migrations\v32x;

class m2_minify_option extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('sitesplat_bbcore_minify_html');
	}

	static public function depends_on()
	{
		return array('\sitesplat\BBCore\migrations\v32x\m1_initial_file');
	}

	public function update_data()
	{
		return [
			['config.add', ['sitesplat_bbcore_minify_html', 0]],
		];
	}
}
