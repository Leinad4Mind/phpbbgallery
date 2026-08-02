<?php
/**
 *
 * @package Auto db Backup
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\autodbbackup\migrations\v_3_3_0;

use phpbb\db\migration\migration;

class install_module extends migration
{
	/**
	 * {@inheritdoc
	 */
	public static function depends_on()
	{
		return ['\devspace\autodbbackup\migrations\v_3_3_0\install_cat'];
	}

	/**
	 * {@inheritdoc
	 */
	public function update_data()
	{
		return [
			// Add the ACP module
			['module.add', [
				'acp', 'ACP_AUTO_DB_BACKUP', [
					'module_basename' => '\devspace\autodbbackup\acp\auto_db_backup_module',
					'modes' => ['main'],
				],
			]],
		];
	}
}
