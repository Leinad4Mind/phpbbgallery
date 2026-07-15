<?php
/*
* @package cBB Chat
* @version v1.2.3 22/04/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\chat\mcp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\chat\mcp\main_module',
			'title'		=> 'MCP_CHAT_BAN',
			'version'	=> '1.2.2',
			'modes'		=> array(
				'config'	=> array('title' => 'MCP_CHAT_BAN', 	'auth' => 'ext_canidev/chat && acl_m_ban', 'cat' => array('MCP_BAN')),
			),
		);
	}
}
