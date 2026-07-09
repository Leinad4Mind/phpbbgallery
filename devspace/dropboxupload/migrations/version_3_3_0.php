<?php
/**
 *
 * @package Dropbox Upload
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\dropboxupload\migrations;

use phpbb\db\migration\migration;

class version_3_3_0 extends migration
{
	/**
	 * {@inheritdoc
	 */
	public function effectively_installed(): bool
	{
		$sql = 'SELECT module_id
				FROM ' . $this->table_prefix . "modules
				WHERE module_class = 'acp'
					AND module_langname = 'DROPBOX_UPLOAD'";
		$result 	= $this->db->sql_query($sql);
		$module_id	= (bool) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

	/**
	 * {@inheritdoc
	 */
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
					'module_basename' => '\devspace\dropboxupload\acp\dropboxupload_module',
					'modes' => ['main'],
				],
			]],
		];
	}
}
