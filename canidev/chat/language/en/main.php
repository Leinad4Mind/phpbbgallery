<?php
/**
 * [English [En]]
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

// Chat language
$lang = array_merge($lang, [
	'CHAT'						=> 'Chat',
	'CHAT_APPLY'				=> 'Apply',
	'CHAT_ARCHIVE'				=> 'Chat archive',
	'CHAT_BAN_DATE'				=> 'End of exclusion',
	'CHAT_BAN_DATE_EXPLAIN'		=> 'The valid format is DD/MM/YYYY hh:mm:ss.',
	'CHAT_BAN_PERIOD'			=> 'Exclusion duration',
	'CHAT_BAN_USER'				=> 'Exclude',
	'CHAT_BBCODE'				=> 'BBcodes',
	'CHAT_CHANGE_NAME'			=> 'Change username',
	'CHAT_COLOR'				=> 'Text colour',
	'CHAT_CONNECT'				=> 'Connect/Disconnect',
	'CHAT_CUSTOM_BBCODES'		=> 'Custom BBcodes',
	'CHAT_DELETE_USER'			=> 'Delete user',
	'CHAT_DEST_ROOM'			=> 'Destination',
	'CHAT_DISCONNECT_MESSAGE'	=> 'You are disconnected.',
	'CHAT_FLOOD_WAIT'			=> 'Flood time is set. Please wait...',
	'CHAT_GUEST'				=> 'Guest_%s',
	'CHAT_GUEST_ROOM'			=> 'General',
	'CHAT_MENTION'				=> 'Mention',
	'CHAT_MOVE'					=> 'Move to other room',
	'CHAT_MOVE_CONFIRM'			=> 'Are you sure you want to move the selected messages?',
	'CHAT_NO_INFORMATION'		=> 'No available information.',
	'CHAT_PM_EXCEED'			=> 'You can not open more private conversations because of a limit set by the administration.',
	'CHAT_PURGE'				=> 'Purge messages',
	'CHAT_PURGE_CONFIRM'		=> 'Are you sure that you want to delete all messages from the <strong><em>%s</em></strong> room?',
	'CHAT_REFRESH'				=> 'Refresh',
	'CHAT_RULES'				=> 'Chat rules',
	'CHAT_SEND_PM'				=> 'Private message',
	'CHAT_SMILIES'				=> 'Smilies',
	'CHAT_SOUND'				=> 'Enable/Disable sound',

	'CHAT_ENTER_AS_GUEST'		=> 'Enter as guest',
	'CHAT_ENTER_AS_REGISTERED'	=> 'Enter as forum member',
	
	'CHAT_STATUS_AVAILABLE'		=> 'Available',
	'CHAT_STATUS_AWAY'			=> 'Away',
	'CHAT_STATUS_BUSY'			=> 'Busy',
	'CHAT_STATUS_HIDDEN'		=> 'Hidden',

	'CHAT_TIP'					=> 'Tip',
	'CHAT_UNBAN_USER'			=> 'Remove exclusion',
	'CHAT_USER_BANNED_PERIOD'		=> 'You are excluded from the chat until: %s',
	'CHAT_USER_BANNED_PERMANENT'	=> 'You are excluded from the chat permanently.',
	'CHAT_USER_ALREADY_EXISTS'		=> 'The user is already in use.',
	'CHAT_VIEW_HISTORY'				=> 'See previous messages',

	'CUSTOM_DATE'		=> 'Custom date',
	'EDIT'				=> 'Edit',
	'HALF_AN_HOUR'		=> 'Half an hour',
	'NEW_TOPIC'			=> 'New Topic',
	'PERMANENT'			=> 'Permanent',
	'QUOTE'				=> 'Quote',

	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
]);

// Text language
$lang = array_merge($lang, []);
