<?php
/** 
* info_mcp_chat.php [English [En]]
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
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
	'MCP_CHAT_BAN'				=> 'Chat Exclusions',
	
	'CHAT_BAN_CELL'				=> 'Username',
	'CHAT_BAN_CELL_EXPLAIN'		=> 'To specify more than one username, enter each one in a new line.<br />
		Use the <em><u>Find a User</u></em> link to find and add users automatically.',
	'CHAT_BAN_LIST'				=> 'Excluded Users',
	'CHAT_EXCLUSIONS_ADDED'		=> 'Exclusions have been modified',
	'CHAT_EXCLUSIONS_DELETED'	=> 'Exclusions have been deleted',
	'CHAT_EXCLUSIONS_ERROR'		=> 'An error has occurred, check the entered data',
	
	'LOG_CHAT_EXCLUSION_ADDED'		=> '<strong>cBB Chat:</strong> Exclusions added<br />» %s',
 	'LOG_CHAT_EXCLUSION_REMOVED'	=> '<strong>cBB Chat:</strong> Exclusions removed<br />» %s',
));
