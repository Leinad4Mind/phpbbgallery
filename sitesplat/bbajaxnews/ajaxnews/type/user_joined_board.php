<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

class user_joined_board extends base
{
	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.user_joined_board';
	}

	public function get_lang_array($data)
	{
		return [
			get_username_string('full', $data['user_id'], $data['username']),
		];
	}

	public function is_special()
	{
		return true;
	}
}
