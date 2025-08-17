<?php
/**
 *
 * @package ACP User Notifications
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

declare(strict_types=1);

namespace devspace\acpusernotifications\migrations;

use phpbb\db\migration\migration;

class acp_modules extends migration
{
   /**
	 * {@inheritdoc
	 */
	public function effectively_installed(): bool
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'acp'
				AND module_langname = 'USER_NOTIFICATIONS'";
		$result 	= $this->db->sql_query($sql);
		$module_id	= $this->db->sql_fetchfield('module_id');

		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

   /**
	 * {@inheritdoc
	 */
	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_USERS',
				[
					'module_basename'	=> 'acp_users',
					'module_langname'	=> 'USER_NOTIFICATIONS',
					'module_mode'		=> 'usernotify',
					'module_display'	=> false,
					'module_auth'		=> 'ext_devspace/acpusernotifications && acl_a_user',
				],
			]],
		];
	}
}
