<?php
/**
 * @package Auto db Backup
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace devspace\autodbbackup\migrations\v_3_3_1;

use phpbb\db\migration\migration;

/** Add owned-backup tracking and retire the unsafe optimize option. */
class security_upgrade extends migration
{
	/** @return string */
	public static function depends_on()
	{
		return '\\devspace\\autodbbackup\\migrations\\v_3_3_0\\install_config';
	}

	/** @return array */
	public function update_data()
	{
		return array(
			array('config_text.add', array('auto_db_backup_manifest', '{}')),
			array('config.remove', array('auto_db_backup_optimize')),
		);
	}
}
