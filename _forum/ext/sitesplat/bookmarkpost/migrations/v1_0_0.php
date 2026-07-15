<?php
/**
*
* Bookmark Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bookmarkpost\migrations;

class v1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		$effectively_installed = true;

		// Post bookmarks table
		if (!$this->db_tools->sql_table_exists($this->table_prefix . 'post_bookmarks'))
		{
			$effectively_installed = false;
		}

		// UCP module
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'ucp'
				AND module_langname = 'UCP_POST_BOOKMARKS_TITLE'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);
		if ($module_id === false)
		{
			$effectively_installed = false;
		}

		return $effectively_installed;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_schema()
	{
		return array(
			'add_tables'		=> array(
				$this->table_prefix . 'post_bookmarks'	=> array(
					'COLUMNS'	=> array(
						'post_id'	=> array('UINT', 0),
						'user_id'	=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> array('post_id', 'user_id'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'		=> array(
				$this->table_prefix . 'post_bookmarks',
			),
		);
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'ucp',
				'UCP_MAIN',
				array(
					'module_basename'	=> '\sitesplat\bookmarkpost\ucp\main_module',
					'modes'				=> array('post_bookmarks'),
				),
			)),
		);
	}
}
