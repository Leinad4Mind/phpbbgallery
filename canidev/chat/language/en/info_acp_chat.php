<?php
/** 
* info_acp_chat.php [English [En]]
* @package cBB Chat
* @version v1.1.2 20/08/2016
*
* @copyright (c) 2016 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_CAT_CHAT'			=> 'Chat',
	
	'ACP_CHAT_CONFIG'		=> 'Main configuration',
	'ACP_CHAT_PAGES'		=> 'Manage pages',
	'ACP_CHAT_ROOMS'		=> 'Manage rooms',
	'ACP_CHAT_TEXTS'		=> 'Static texts and Rules',

	'LOG_CHAT_CONFIG'			=> '<strong>cBB Chat:</strong> Changed main configuration',
	'LOG_CHAT_ROOM_REMOVED'		=> '<strong>cBB Chat:</strong> Deleted room <em>%s</em> and their messages',
));
