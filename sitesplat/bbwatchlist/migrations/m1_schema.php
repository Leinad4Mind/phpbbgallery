<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbwatchlist\migrations;

class m1_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'watch_keywords');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'watch_keywords'	=> array(
					'COLUMNS'		=> array(
						'keyword_id'	=> array('UINT', null, 'auto_increment'),
						'user_id'		=> array('UINT', 0),
						'keyword'		=> array('VCHAR:255', ''),
						'search_type'	=> array('BOOL', 0),
					),
					'PRIMARY_KEY'	=> 'keyword_id',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'		=> array(
				$this->table_prefix . 'watch_keywords',
			),
		);
	}
}
