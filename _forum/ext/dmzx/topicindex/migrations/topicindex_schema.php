<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\migrations;

class topicindex_schema extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'forum_lists'	=> array(
					'COLUMNS'	=> array(
						'list_id'		=> array('UINT', null, 'auto_increment'),
						'list_name'		=> array('VCHAR_UNI:255', ''),
						'list_forum'	=> array('TEXT_UNI', ''),
					),
					'PRIMARY_KEY'	=> 'list_id',
				),
			),
			'add_columns'	=> array(
				$this->table_prefix . 'topics' => array(
					'inindex_topic'		=> array('TINT:1', 0),
					'outindex_topic'	=> array('TINT:1', 0),
				),

				$this->table_prefix . 'forums' => array(
					'post_index' 		=> array('UINT:10', 0),
					'default_inindex' 	=> array('TINT:1', 0),
					'tag_filter' 		=> array('TINT:1', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables' => array(
				$this->table_prefix . 'forum_lists',
			),
			'drop_columns' => array(
				$this->table_prefix . 'posts'	=> array(
					'inindex_topic',
					'outindex_topic',
				),

				$this->table_prefix . 'forums'	=> array(
					'post_index',
					'default_inindex',
					'tag_filter',
				),
			),
		);
	}
}
