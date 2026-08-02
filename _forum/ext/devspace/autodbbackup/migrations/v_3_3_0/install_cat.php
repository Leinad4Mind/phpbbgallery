<?php
/**
 *
 * @package Auto db Backup
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

declare(strict_types=1);

namespace devspace\autodbbackup\migrations\v_3_3_0;

use phpbb\db\migration\migration;

class install_cat extends migration
{
	/**
	 * {@inheritdoc
	 */
	public function effectively_installed(): bool
	{
		$sql = 'SELECT module_id
				FROM ' . $this->table_prefix . "modules
				WHERE module_class = 'acp'
					AND module_langname = 'ACP_AUTO_DB_BACKUP_SETTINGS'";
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
		if ($this->module_check())
		{
			return [
				// Add the ACP cat module
				['module.add', ['acp', 'ACP_CAT_MAINTENANCE', 'ACP_AUTO_DB_BACKUP']],
			];
		}
		else
		{
			return [];
		}
	}

	/**
	 * {@inheritdoc
	 */
	protected function module_check()
	{
		$sql = 'SELECT module_id
                FROM ' . $this->table_prefix . "modules
                WHERE module_class = 'acp'
                    AND module_langname = 'ACP_AUTO_DB_BACKUP'
					AND right_id - left_id > 1";

		$result    = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		// return true if module is empty, false if has children
		return (bool) !$module_id;
	}
}
