<?php
/**
 * [English [En]]
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
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
 	'LOG_CHAT_MESSAGE_MOVED'		=> '<strong>cBB Chat:</strong> Message moved from <em>%1$s</em> to <em>%2$s</em><br />» %3$s',
	'LOG_CHAT_MESSAGES_MOVED'		=> [
		1 => '<strong>cBB Chat:</strong> 1 message moved from <em>%1$s</em> to <em>%2$s</em>',
		2 => '<strong>cBB Chat:</strong> %3$d messages moved from <em>%1$s</em> to <em>%2$s</em>',
	],
	'LOG_CHAT_MESSAGE_REMOVED'		=> '<strong>cBB Chat:</strong> Message removed <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED'		=> [
		1 => '<strong>cBB Chat:</strong> 1 message removed from <em>%1$s</em>',
		2 => '<strong>cBB Chat:</strong> %2$d messages removed from <em>%1$s</em>',
	],
]);
