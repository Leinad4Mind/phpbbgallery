<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\htmlemail\acp;

class htmlemail_info
{
	public function module()
	{
		return [
			'filename' => '\leinad4mind\htmlemail\acp\htmlemail_module',
			'title'    => 'ACP_HTMLEMAIL_TITLE',
			'modes'    => [
				'overview' => [
					'title' => 'ACP_HTMLEMAIL_OVERVIEW',
					'auth'  => 'ext_leinad4mind/htmlemail && acl_a_board',
					'cat'   => ['ACP_BOARD_CONFIGURATION'],
				],
			],
		];
	}
}
