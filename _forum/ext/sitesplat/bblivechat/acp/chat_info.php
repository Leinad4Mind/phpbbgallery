<?php
/**
 * BBlivechat
 * @copyright (c) 2020 SiteSplat. All rights reserved.
 * @license Proprietary
 */

namespace sitesplat\bblivechat\acp;

class chat_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bblivechat\acp\chat_module',
			'title'		=> 'BBlivechat',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'SETTINGS', 'auth' => 'ext_sitesplat/bblivechat && acl_a_board', 'cat' => array('SITESPLAT_EXT')),
				'rooms'		=> array('title' => 'Rooms', 'auth' => 'ext_sitesplat/bblivechat && acl_a_board', 'cat' => array('SITESPLAT_EXT')),
				'logs'		=> array('title' => 'VIEW_FORUM_LOGS', 'auth' => 'ext_sitesplat/bblivechat && acl_a_board', 'cat' => array('SITESPLAT_EXT')),
			),
		);
	}
}
