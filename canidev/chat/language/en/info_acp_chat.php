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
	'ACP_CAT_CHAT'			=> 'Chat',
	
	'ACP_CHAT_CONFIG'		=> 'Main configuration',
	'ACP_CHAT_PAGES'		=> 'Manage pages',
	'ACP_CHAT_ROOMS'		=> 'Manage rooms',
	'ACP_CHAT_TEXTS'		=> 'Static texts and Rules',

	'LOG_CHAT_CONFIG'				=> '<strong>cBB Chat:</strong> Changed main configuration',
	'LOG_CHAT_EXCLUSION_ADDED'		=> '<strong>cBB Chat:</strong> Exclusions added<br />» %s',
 	'LOG_CHAT_EXCLUSION_REMOVED'	=> '<strong>cBB Chat:</strong> Exclusions removed<br />» %s',
	'LOG_CHAT_MESSAGE_MOVED'		=> '<strong>cBB Chat:</strong> Message moved from <em>%1$s</em> to <em>%2$s</em><br />» %3$s',
	'LOG_CHAT_MESSAGES_MOVED'		=> [
		1 => '<strong>cBB Chat:</strong> 1 message moved from <em>%1$s</em> to <em>%2$s</em>',
		2 => '<strong>cBB Chat:</strong> %3$d messages moved from <em>%1$s</em> to <em>%2$s</em>',
	],
	'LOG_CHAT_MESSAGE_REMOVED'		=> '<strong>cBB Chat:</strong> Message deleted <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED'		=> [
		1 => '<strong>cBB Chat:</strong> 1 message deleted from <em>%1$s</em>',
		2 => '<strong>cBB Chat:</strong> %2$d messages deleted from <em>%1$s</em>',
	],
	'LOG_CHAT_ROOM_REMOVED'			=> '<strong>cBB Chat:</strong> Deleted room <em>%s</em> and their messages',
]);
