<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('bbcompress_saved_storage', 0)),
			array('config.add', array('bbcompress_allowed_posts', 1)),
			array('config.add', array('bbcompress_allowed_avatars', 1)),
			array('config.add', array('bbcompress_driver', 'PHP')),
			array('config.add', array('tinify_api_key', '')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BBCOMPRESS_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_BBCOMPRESS_TITLE',
				array(
					'module_basename'	=> '\sitesplat\bbcompress\acp\main_module',
				),
			)),
		);
	}
}
