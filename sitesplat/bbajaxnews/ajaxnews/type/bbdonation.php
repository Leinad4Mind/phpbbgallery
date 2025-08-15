<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

class bbdonation extends base
{
	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.bbdonation';
	}

	public function get_lang_array($data)
	{
		$sql = 'SELECT username, user_colour
				FROM ' . $this->users_table . '
				WHERE user_id = ' . (int) $data['user_id'];
		$result = $this->db->sql_query($sql);
		$user = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return [
			get_username_string('full', $data['user_id'], $user['username'], $user['user_colour']),
		];
	}

	public function is_special()
	{
		return true;
	}
}
