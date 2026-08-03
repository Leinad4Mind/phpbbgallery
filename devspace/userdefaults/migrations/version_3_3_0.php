<?php
/**
 *
 * @package User Defaults Extension
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\userdefaults\migrations;

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
					AND module_langname = 'USER_DEFAULTS'";
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
		/**
		 * Add or update data in the database
		 *
		 * @return array Array of table data
		 * @access public
		 */
		return [
			['config.add', ['ud_allow_pm', 1]],
			['config.add', ['ud_allow_massemail', 1]],
			['config.add', ['ud_allow_viewemail', 1]],
			['config.add', ['ud_allow_viewonline', 0]],
			['config.add', ['ud_date_format', 'd M Y H:i']],
			['config.add', ['ud_moderation_queue', 0]],
			['config.add', ['ud_notifications', 0]],
			['config.add', ['ud_notify', 0]],
			['config.add', ['ud_notify_pm', 1]],
			['config.add', ['ud_options', 230271]],
			['config.add', ['ud_post_sd', 'a']],
			['config.add', ['ud_post_sk', 't']],
			['config.add', ['ud_post_st', 0]],
			['config.add', ['ud_topic_sd', 'd']],
			['config.add', ['ud_topic_sk', 't']],
			['config.add', ['ud_topic_st', 0]],
			['config.add', ['ud_type_bookmark', 0]],
			['config.add', ['ud_type_forum_post', 0]],
			['config.add', ['ud_type_group', 0]],
			['config.add', ['ud_type_needs_approval', 0]],
			['config.add', ['ud_type_pm', 0]],
			['config.add', ['ud_type_pm_close', 0]],
			['config.add', ['ud_type_pm_report', 0]],
			['config.add', ['ud_type_post', 1]],
			['config.add', ['ud_type_quote', 0]],
			['config.add', ['ud_type_report', 0]],
			['config.add', ['ud_type_report_close', 0]],
			['config.add', ['ud_type_topic', 1]],

			// Add the ACP module
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'USER_DEFAULTS']],

			['module.add', [
				'acp', 'USER_DEFAULTS', [
					'module_basename' => '\devspace\userdefaults\acp\userdefaults_module',
					'modes' => ['manage'],
				],
			]],
		];
	}
}
