<?php

/*
* @package phpBB Extension - Discussion Encouragement With Quick Login
* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace forumflair\discencql;

class ext extends \phpbb\extension\base
{
	/** Enable extension if phpBB version requirement is met **/
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.3.4', '>=');
	}
}
