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
		return [
			['config.add', ['dropbox_folder', '']],
			['config.add', ['dropbox_folder_opt', 'DEFAULT']],
			['config.add', ['dropbox_frequency_count', 0, 1]],
			['config.add', ['dropbox_frequency_interval', 1]],
			['config.add', ['dropbox_key', '']],
			['config.add', ['dropbox_secret', '']],
			['config.add', ['dropbox_token', '']],
			['config.add', ['dropbox_upload_enable', 0]],

			['module.add', [
				'acp', 'ACP_AUTO_DB_BACKUP', [
					'module_basename' => '\david63\dropboxupload\acp\dropboxupload_module',
					'modes' => ['main'],
				],
			]],
		];
	}
}
