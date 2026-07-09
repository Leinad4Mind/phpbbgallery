<?php
/**
 *
 * @package Log Searches Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\logsearches\migrations;

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
					AND module_langname = 'SEARCH_LOG'";
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
			['config.add', ['search_log_all', '0']],
			['config.add', ['search_log_per_page', '25']],
			['config.add', ['search_log_prune_all', '0']],
			['config.add', ['search_log_prune_days', '0']],
			['config.add', ['search_log_prune_gc', '86400']],
			['config.add', ['search_log_prune_last_gc', time()]],

			// Add the ACP modules
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'SEARCH_LOG']],

			['module.add', [
				'acp', 'SEARCH_LOG', [
					'module_basename' => '\devspace\logsearches\acp\logsearches_options_module',
					'modes' => ['main'],
				],
			]],

			['module.add', [
				'acp', 'ACP_FORUM_LOGS', [
					'module_basename' => '\devspace\logsearches\acp\logsearches_module',
					'modes' => ['main'],
				],
			]],
		];
	}

	/**
	 * {@inheritdoc
	 */
	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'search_log' => [
					'COLUMNS' => [
						'log_id' 			=> ['UINT', null, 'auto_increment'],
						'log_search_type'	=> ['BOOL', 0],
						'user_id' 			=> ['UINT', 0],
						'log_data' 			=> ['TEXT_UNI', ''],
						'log_ip' 			=> ['VCHAR:40', ''],
						'log_time' 			=> ['UINT:11', 0],
						'log_title' 		=> ['VCHAR:60', ''],
					],
					'PRIMARY_KEY' => 'log_id',
				],
			],
		];
	}

	/**
	 * {@inheritdoc
	 */
	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'search_log',
			],
		];
	}
}
