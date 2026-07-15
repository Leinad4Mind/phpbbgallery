<?php
/**
*
* @package BBlazy
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bblazy\migrations;

class m1_add_lqip extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'attachments', 'lqip');
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'attachments' => [
					'lqip' => ['TEXT', ''],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'attachments' => [
					'lqip',
				],
			],
		];
	}
}
