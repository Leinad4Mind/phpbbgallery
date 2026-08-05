<?php
/**
 *
 * Search Results extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 ForumHulp.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace forumhulp\searchresults;

use phpbb\extension\base;

class ext extends base
{
	public function is_enableable(): bool
	{
		if (!class_exists('forumhulp\\helper\\helper'))
		{
			$this->container->get('user')->add_lang_ext('forumhulp/searchresults', 'info_acp_searchresults');
			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);
			return false;
		}

		return $this->container->get('ext.manager')->is_enabled('forumhulp/helper');
	}
}
