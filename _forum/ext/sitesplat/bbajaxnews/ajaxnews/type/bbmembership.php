<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

class bbmembership extends base
{
	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.bbmembership';
	}

	public function get_lang_array($data)
	{
		$sql_ary = [
			'SELECT'	=> 'u.username, u.user_colour',
			'FROM'	=> [
				$this->users_table		=> 'u',
			],
			'WHERE'		=> 'u.user_id = ' . (int) $data['user_id'],
		];
		$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
		$user = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return [
			get_username_string('full', (int) $data['user_id'], $user['username'], $user['user_colour'], false, $this->url . append_sid('/memberlist.php', 'mode=viewprofile')),
			$data['level'],
		];
	}

	public function is_special()
	{
		return true;
	}
}
