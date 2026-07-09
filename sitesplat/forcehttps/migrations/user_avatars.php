<?php
/**
* Force https extension for the phpBB Forum Software package.
* @copyright (c) 2017 sitesplat.com <http://sitesplat.com>
* @license Proprietary
*/
namespace sitesplat\forcehttps\migrations;

use phpbb\db\migration\migration;

class user_avatars extends migration
{
	public function update_data()
	{
		return [['custom', [[$this, 'update_remote_user_avatars']]]];
	}

	public function update_remote_user_avatars()
	{
		$sql = 'UPDATE ' . USERS_TABLE . " SET user_avatar = REPLACE(user_avatar, 'http://', 'https://')";
		$this->db->sql_query($sql);
	}
}