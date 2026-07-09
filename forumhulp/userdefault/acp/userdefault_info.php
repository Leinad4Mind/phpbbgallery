<?php
/**
*
* UserDefaults extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\userdefault\acp;

class userdefault_info
{
	function module()
	{
		return array(
			'filename'	=> '\forumhulp\userdefault\acp\userdefault_module',
			'title'		=> 'ACP_USERDEFAULT',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_USERDEFAULT',
					'auth' => 'ext_forumhulp/userdefault && acl_a_board',
					'cat' => array('ACP_BOARD_CONFIGURATION')
				),
			),
		);
	}
}
