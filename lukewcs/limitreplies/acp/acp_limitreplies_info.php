<?php
/**
*
* Limit Multiple Replies. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
* @license GNU General Public License, version 2 (GPL-2.0-only)
*
* Note: This extension is 100% genuine handcraft and consists of selected
*       natural raw materials. There was no AI involved in making it.
*
*/

namespace lukewcs\limitreplies\acp;

class acp_limitreplies_info
{
	function module()
	{
		return [
			'filename'	=> '\lukewcs\limitreplies\acp\acp_limitreplies_module',
			'title'		=> 'LIMITREPLIES_NAV_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'LIMITREPLIES_NAV_CONFIG',
					'auth'	=> 'ext_lukewcs/limitreplies && acl_a_board',
					'cat'	=> ['LIMITREPLIES_NAV_TITLE'],
				],
			],
		];
	}
}
