<?php
/*
* @package cBB Chat
* @version v1.2.0 02/03/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\chat\acp\main_module',
			'title'		=> 'ACP_CAT_CHAT',
			'version'	=> '1.2.0',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
				'pages'		=> array('title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
				'rooms'		=> array('title' => 'ACP_CHAT_ROOMS', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
				'texts'		=> array('title' => 'ACP_CHAT_TEXTS', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
			),
		);
	}
}
