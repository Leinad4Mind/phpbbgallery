<?php
/*
* @name main_info.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\mcp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\chat\mcp\main_module',
			'title'		=> 'MCP_CHAT_BAN',
			'version'	=> '1.1.2',
			'modes'		=> array(
				'config'	=> array('title' => 'MCP_CHAT_BAN', 	'auth' => 'ext_canidev/chat && acl_m_ban', 'cat' => array('MCP_BAN')),
			),
		);
	}
}
