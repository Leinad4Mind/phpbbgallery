<?php
/**
 * @package cBB Chat
 * @version 1.2.5 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\acp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\canidev\chat\acp\main_module',
			'title'		=> 'ACP_CAT_CHAT',
			'version'	=> '1.2.5',
			'modes'		=> [
				'config'	=> ['title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
				'pages'		=> ['title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
				'rooms'		=> ['title' => 'ACP_CHAT_ROOMS', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
				'texts'		=> ['title' => 'ACP_CHAT_TEXTS', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
			],
		];
	}
}
