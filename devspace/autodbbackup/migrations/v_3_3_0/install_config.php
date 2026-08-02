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

class install_config extends migration
{
	/**
	 * {@inheritdoc
	 */
	public static function depends_on()
	{
		return ['\devspace\autodbbackup\migrations\v_3_3_0\install_module'];
	}

	/**
	 * {@inheritdoc
	 */
	public function update_data()
	{
		return [
			['config.add', ['auto_db_backup_copies', 5]],
			['config.add', ['auto_db_backup_enable', 0]],
			['config.add', ['auto_db_backup_filetype', 'text']],
			['config.add', ['auto_db_backup_gc', 1]],
			['config.add', ['auto_db_backup_maintain_freq', 0]],
			['config.add', ['auto_db_backup_next_gc', time()]],
			['config.add', ['auto_db_backup_optimize', 0]],
		];
	}
}
