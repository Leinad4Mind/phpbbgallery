<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

class user_joined_group extends base
{
	protected $group_helper;
	public function set_dependencies(\phpbb\group\helper $group_helper)
	{
		$this->group_helper = $group_helper;
	}

	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.user_joined_group';
	}

	public function get_lang_array($data)
	{
		$users = [];
		foreach ($data['users'] as $user_id => $username)
		{
			$users[] = '<a href="' . generate_board_url() . '/' . append_sid('memberlist.' . $this->php_ext, 'mode=viewprofile&amp;u=' . $user_id) . '">' . $username . '</a>';
		}

		$users_string = implode(', ', $users); // result is something like: admin1, admin2, admin3
		$nice_user_string = strrev(preg_replace('/ ,/', ' ' . strrev($this->language->lang('AND')) . ' ', strrev($users_string), 1)); // now the result is: admin1, admin2 and admin3. Nicer, right? ;)
		$group_name = $this->group_helper->get_name($data['group_name']);
		return [
			$nice_user_string,
			'<a href="' . generate_board_url() . '/' . append_sid('memberlist.' . $this->php_ext, 'mode=group&amp;g=' . $data['group_id']) . '">' . $group_name . '</a>',
		];
	}

	public function is_special()
	{
		return true;
	}
}
