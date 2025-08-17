<?php
/**
*
* @package Auto db Backup (3.2)
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\autodbbackup\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public function update_data()
	{
		$update_data = array();

		$update_data[] = array('config.add', array('auto_db_backup_copies', 5));
		$update_data[] = array('config.add', array('auto_db_backup_enable', 0));
		$update_data[] = array('config.add', array('auto_db_backup_filetype', 'text'));
		$update_data[] = array('config.add', array('auto_db_backup_gc', 1));
		$update_data[] = array('config.add', array('auto_db_backup_maintain_freq', 0));
		$update_data[] = array('config.add', array('auto_db_backup_next_gc', time()));
		$update_data[] = array('config.add', array('auto_db_backup_optimize', 0));

		if ($this->module_check())
		{
			$update_data[] = array('module.add', array('acp', 'ACP_CAT_MAINTENANCE', 'ACP_AUTO_DB_BACKUP'));
		}

		$update_data[] = array('module.add', array(
			'acp', 'ACP_AUTO_DB_BACKUP', array(
				'module_basename'	=> '\david63\autodbbackup\acp\auto_db_backup_module',
				'modes'				=> array('main'),
			),
		));

		return $update_data;
	}

	protected function module_check()
	{
		$sql = 'SELECT module_id
				FROM ' . $this->table_prefix . "modules
    			WHERE module_class = 'acp'
        			AND module_langname = 'ACP_AUTO_DB_BACKUP'
        			AND right_id - left_id > 1";

		$result		= $this->db->sql_query($sql);
		$module_id	= (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		// return true if module is empty, false if has children
		return (bool) !$module_id;
	}
}
