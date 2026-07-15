<?php
/*
* @package cBB Chat
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\mcp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\chat\mcp\main_module',
			'title'		=> 'MCP_CHAT_BAN',
			'version'	=> '1.2.1',
			'modes'		=> array(
				'config'	=> array('title' => 'MCP_CHAT_BAN', 	'auth' => 'ext_canidev/chat && acl_m_ban', 'cat' => array('MCP_BAN')),
			),
		);
	}
}
