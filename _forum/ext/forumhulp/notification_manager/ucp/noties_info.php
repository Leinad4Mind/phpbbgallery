<?php
/**
*
* Notification_manager for the phpBB Forum Software package.
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\notification_manager\ucp;

class noties_info
{
	function module()
	{
		return array(
			'filename'	=> '\forumhulp\notification_manager\ucp\noties_module',
			'title'     => 'UCP_NOTIES',
			'version'   => '1.0.0',
			'modes'     => array(
				'noties'	=> array(
						'title'	=> 'UCP_NOTIES',
						'auth'	=> 'ext_forumhulp/notification_manager',
						'cat'	=> array('UCP_MAIN')
				),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
