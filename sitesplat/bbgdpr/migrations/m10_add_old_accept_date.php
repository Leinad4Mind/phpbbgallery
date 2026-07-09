<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m10_add_old_accept_date extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_privacy_old_accept_date');
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m9_request_delete');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_privacy_old_accept_date'	=> array('UINT:11', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_privacy_old_accept_date',
				),
			),
		);
	}
}
