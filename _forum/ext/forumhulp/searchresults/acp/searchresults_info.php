<?php
/**
 *
 * Search Results extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 ForumHulp.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace forumhulp\searchresults\acp;

class searchresults_info
{
	public function module(): array
	{
		return [
			'filename' => '\\forumhulp\\searchresults\\acp\\searchresults_module',
			'title' => 'ACP_SEARCHRESULTS',
			'version' => '3.3.0',
			'modes' => [
				'log' => [
					'title' => 'ACP_SEARCHRESULTS',
					'auth' => 'ext_forumhulp/searchresults && acl_a_viewlogs',
					'cat' => ['ACP_FORUM_LOGS'],
				],
			],
		];
	}
}
