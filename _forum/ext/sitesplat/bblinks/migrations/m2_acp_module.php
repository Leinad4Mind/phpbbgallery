<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\migrations;

class m2_acp_module extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bblinks\migrations\m1_init_config');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'BBLINKS_TITLE'
			)),
			array('module.add', array(
				'acp',
				'BBLINKS_TITLE',
				array(
					'module_basename'	=> '\sitesplat\bblinks\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
