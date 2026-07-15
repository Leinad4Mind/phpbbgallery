<?php
/*
* @package cBB Chat
* @version v1.2.0 02/03/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\migrations;

class v120 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.0', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\v113',
		);
	}
	
	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'chat_users' => array(
					'user_groups'		=> array('VCHAR', ''),
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('config.remove', 	array('chat_enabled')),
			array('config.add',		array('chat_pm_maxage', 1)),
			array('config.add',		array('chat_pm_ignore_flood', 0)),
			array('config.add', 	array('cbb_asset_check', 0)),
			array('config.update',	array('chat_version', '1.2.0')),
			
			array('custom', array(array($this, 'clean_user_groups'))),
		);
	}
	
	public function clean_user_groups()
	{
		$user_id_ary = $users_ary = array();
		
		// Delete session of registered users to force auto-update
		$sql = 'DELETE FROM ' . $this->table_prefix . 'chat_users
			WHERE user_id <> ' . ANONYMOUS;
		$this->db->sql_query($sql);

		// Set default group for guests
		$sql = 'UPDATE ' . $this->table_prefix . "chat_users
			SET user_groups = '1'
			WHERE user_id = " . ANONYMOUS;
		$this->db->sql_query($sql);
	}
}
