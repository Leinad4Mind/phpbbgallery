<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

use \sitesplat\bbgdpr\ext;

class m2_add_accept_dates extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_privacy_accept_date');
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m1_ucp');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_privacy_accept_date'	=> array('UINT:11', 0),
					'user_cookie_accept' 		=> array('UINT:1', ext::COOKIE_NOT_YET),
					'user_cookie_accept_date'	=> array('UINT:11', 0),
					'user_mcp_accept_date'		=> array('UINT:11', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_mcp_accept_date',
					'user_cookie_accept_date',
					'user_cookie_accept',
					'user_privacy_accept_date',
				),
			),
		);
	}
}
