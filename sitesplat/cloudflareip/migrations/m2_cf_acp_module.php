<?php
/**
*
* Cloudflare IP
*
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\cloudflareip\migrations;

class m2_cf_acp_module extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\cloudflareip\migrations\m1_add_cf_api_data');
	}

	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_CLOUDFLARE')),
			array('module.add', array(
				'acp', 'ACP_CLOUDFLARE', array(
					'module_basename'	=> '\sitesplat\cloudflareip\acp\cf_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}