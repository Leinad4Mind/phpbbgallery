<?php
/**
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\mcp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\canidev\chat\mcp\main_module',
			'title'		=> 'MCP_CHAT_BAN',
			'version'	=> '1.2.5',
			'modes'		=> [
				'config'	=> ['title' => 'MCP_CHAT_BAN', 	'auth' => 'ext_canidev/chat && acl_m_ban', 'cat' => ['MCP_BAN']],
			],
		];
	}
}
