<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
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
