<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\dropboxupload\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('dropbox_folder', '')),
			array('config.add', array('dropbox_folder_opt', 'DEFAULT')),
			array('config.add', array('dropbox_frequency_count', 0, 1)),
			array('config.add', array('dropbox_frequency_interval', 1)),
			array('config.add', array('dropbox_key', '')),
			array('config.add', array('dropbox_secret', '')),
			array('config.add', array('dropbox_token', '')),
			array('config.add', array('dropbox_upload_enable', 0)),

			array('module.add', array(
				'acp', 'ACP_AUTO_DB_BACKUP', array(
					'module_basename'	=> '\david63\dropboxupload\acp\dropboxupload_module',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}
