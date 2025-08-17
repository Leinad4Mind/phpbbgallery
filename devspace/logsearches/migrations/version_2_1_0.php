<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logsearches\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('search_log_all', '0')),
			array('config.add', array('search_log_enable', '1')),
			array('config.add', array('search_log_per_page', '25')),
			array('config.add', array('search_log_prune_all', '0')),
			array('config.add', array('search_log_prune_days', '0')),
			array('config.add', array('search_log_prune_gc', '86400')),
			array('config.add', array('search_log_prune_last_gc', time())),

			// Add the ACP modules
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'SEARCH_LOG')),

			array('module.add', array(
				'acp', 'SEARCH_LOG', array(
					'module_basename'	=> '\david63\logsearches\acp\logsearches_options_module',
					'modes'				=> array('main'),
				),
			)),

			array('module.add', array(
				'acp', 'ACP_FORUM_LOGS', array(
					'module_basename'	=> '\david63\logsearches\acp\logsearches_module',
					'modes'				=> array('main'),
				),
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'search_log'	=> array(
					'COLUMNS'	=> array(
						'log_id'			=> array('UINT', null, 'auto_increment'),
						'log_search_type'	=> array('BOOL', 0),
						'user_id'			=> array('UINT', 0),
						'log_data'			=> array('TEXT_UNI', ''),
						'log_ip'			=> array('VCHAR:40', ''),
						'log_time'			=> array('UINT:11', 0),
					),
					'PRIMARY_KEY' => 'log_id',
				),
			),
		);
	}

	/**
	* Drop the search_log table schema from the database
	*
	* @return array Array of table schema
	* @access public
	*/
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'search_log',
			),
		);
	}
}
