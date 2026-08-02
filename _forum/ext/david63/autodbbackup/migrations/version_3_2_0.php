<?php
/**
 * @package Auto db Backup
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\autodbbackup\migrations;

use phpbb\db\migration\migration;

/** Security and reliability upgrade. */
class version_3_2_0 extends migration
{
	/** @return string */
	public static function depends_on()
	{
		return '\\david63\\autodbbackup\\migrations\\version_2_1_0';
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
