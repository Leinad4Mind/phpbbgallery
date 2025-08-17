<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\castle\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('castle_app_id', '')),
			array('config.add', array('castle_api_secret', '')),
			array('config.add', array('castle_hook_configured', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_CASTLE_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_CASTLE_TITLE',
				array(
					'module_basename'	=> '\sitesplat\castle\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
