<?php
/**
*
* BBtracking
*
* @copyright (c) 2017, Sitesplat
* @license private
*/

namespace sitesplat\bbtracking\migrations;

class m1_initial_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'tracking' => array(
					'COLUMNS' => array(
						'tracking_id'   => array('UINT', NULL, 'auto_increment'),
						'tracking_user'	=> array('UINT', 0),
						'tracking_type' => array('TINT:4', 0),
						'tracking_time' => array('TIMESTAMP', 0),
						'tracking_data' => array('MTEXT_UNI', ''),
					),
					'PRIMARY_KEY' => 'tracking_id',
				),
			),
			'add_columns'	=> array(
				$this->table_prefix . 'groups'	=> array(
					'group_tracked'	=> array('BOOL', 0),
				),
				$this->table_prefix . 'users'	=> array(
					'user_tracked'	=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'groups'	=> array(
					'group_tracked',
				),
				$this->table_prefix . 'users'	=> array(
					'user_tracked',
				),
			),
			'drop_tables'	=> array(
				$this->table_prefix . 'tracking'
			),
		);
	}
}
