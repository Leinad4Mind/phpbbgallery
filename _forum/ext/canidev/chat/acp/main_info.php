<?php
/*
* @name main_info.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\chat\acp\main_module',
			'title'		=> 'ACP_CAT_CHAT',
			'version'	=> '1.1.2',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
				'pages'		=> array('title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
				'rooms'		=> array('title' => 'ACP_CHAT_ROOMS', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
				'texts'		=> array('title' => 'ACP_CHAT_TEXTS', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => array('ACP_CAT_CHAT')),
			),
		);
	}
}
