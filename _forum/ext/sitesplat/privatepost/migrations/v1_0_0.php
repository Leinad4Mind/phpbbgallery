<?php
/**
*
* Private Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\privatepost\migrations;

class v1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'posts', 'post_private');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'posts'	=> array(
					'post_private'	=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'posts'	=> array(
					'post_private',
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('permission.add', array('f_seeprivateposts', false)),
		);
	}
}
