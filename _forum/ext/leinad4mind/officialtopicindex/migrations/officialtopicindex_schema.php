<?php
/**
 *
 * @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\officialtopicindex\migrations;

class officialtopicindex_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'forum_lists')
			&& $this->db_tools->sql_column_exists($this->table_prefix . 'topics', 'inindex_topic')
			&& $this->db_tools->sql_column_exists($this->table_prefix . 'topics', 'outindex_topic')
			&& $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'post_index')
			&& $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'default_inindex')
			&& $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'tag_filter');
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'forum_lists' => [
					'COLUMNS' => [
						'list_id' => ['UINT', null, 'auto_increment'],
						'list_name' => ['VCHAR_UNI:255', ''],
						'list_forum' => ['TEXT_UNI', ''],
					],
					'PRIMARY_KEY' => 'list_id',
				],
			],
			'add_columns' => [
				$this->table_prefix . 'topics' => [
					'inindex_topic' => ['TINT:1', 0],
					'outindex_topic' => ['TINT:1', 0],
				],
				$this->table_prefix . 'forums' => [
					'post_index' => ['UINT:10', 0],
					'default_inindex' => ['TINT:1', 0],
					'tag_filter' => ['TINT:1', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'forum_lists',
			],
			'drop_columns' => [
				$this->table_prefix . 'topics' => [
					'inindex_topic',
					'outindex_topic',
				],
				$this->table_prefix . 'forums' => [
					'post_index',
					'default_inindex',
					'tag_filter',
				],
			],
		];
	}
}
