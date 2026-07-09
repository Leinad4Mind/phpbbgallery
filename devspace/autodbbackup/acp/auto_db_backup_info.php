<?php
/**
 *
 * @package Auto db Backup
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\autodbbackup\acp;

class auto_db_backup_info
{
	public function module()
	{
		return [
			'filename'	=> '\devspace\autodbbackup\acp\auto_db_backup_module',
			'title' 	=> 'ACP_AUTO_DB_BACKUP',
			'modes' 	=> [
				'main' => ['title' => 'ACP_AUTO_DB_BACKUP_SETTINGS', 'auth' => 'ext_devspace/autodbbackup && acl_a_backup', 'cat' => ['ACP_AUTO_DB_BACKUP']],
			],
		];
	}
}
