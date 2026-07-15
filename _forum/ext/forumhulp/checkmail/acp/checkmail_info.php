<?php
/**
*
* @package Check mail
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\checkmail\acp;

class checkmail_info
{
	function module()
	{
		return array(
			'filename'	=> '\forumhulp\checkmail\acp\checkmail_module',
			'title'		=> 'ACP_CHECKMAIL',
			'modes'		=> array(
				'pages'	=> array(
					'title' => 'ACP_CHECKMAIL_SETTINGS',
					'auth' => 'ext_forumhulp/checkmail && acl_a_board',
					'cat' => array('ACP_CHECKMAIL')
				),
			),
		);
	}
}
