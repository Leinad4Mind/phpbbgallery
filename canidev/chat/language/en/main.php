<?php
/** 
* main.php [English [En]]
* @package cBB Chat
* @version v1.1.2 20/08/2016
*
* @copyright (c) 2016 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Chat language
$lang = array_merge($lang, array(
	'CHAT'						=> 'Chat',
	'CHAT_ARCHIVE'				=> 'Chat archive',
	'CHAT_BAN_DATE'				=> 'End of exclusion',
	'CHAT_BAN_DATE_EXPLAIN'		=> 'The valid format is DD/MM/YY hh:mm:ss.',
	'CHAT_BAN_PERIOD'			=> 'Exclusion duration',
	'CHAT_BAN_USER'				=> 'Exclude',
	'CHAT_BBCODE'				=> 'BBcodes',
	'CHAT_CANCEL'				=> 'Cancel',
	'CHAT_CLEAR_BBCODE'			=> 'Delete BBcode',
	'CHAT_CLEAR_INPUT'			=> 'Delete all',
	'CHAT_COLOR'				=> 'Text colour',
	'CHAT_CONNECT'				=> 'Connect/Disconnect',
	'CHAT_CUSTOM_BBCODES'		=> 'Custom BBcodes',
	'CHAT_DELETE_SELECTED'		=> 'Delete selected',
	'CHAT_DELETE_USER'			=> 'Delete user',
	'CHAT_DISCONNECT_MESSAGE'	=> 'You are disconnected.',
	'CHAT_FLOOD_WAIT'			=> 'Flood time is set. Please wait...',
	'CHAT_GUEST_ROOM'			=> 'General',
	'CHAT_MENTION'				=> 'Mention',
	'CHAT_NO_INFORMATION'		=> 'No available information.',
	'CHAT_PM_EXCEED'			=> 'You can not open more private conversations because of a limit set by the administration.',
	'CHAT_PURGE'				=> 'Purge messages',
	'CHAT_PURGE_CONFIRM'		=> 'Are you sure that you want to delete all messages from the <strong><em>%s</em></strong> room?',
	'CHAT_REFRESH'				=> 'Refresh',
	'CHAT_REMAINING_CHARS'		=> 'characters left.',
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
	
	'CHAT_SUBMIT'				=> 'Accept',
	'CHAT_TIP'					=> 'Tip',
	'CHAT_UNBAN_USER'			=> 'Remove exclusion',
	'CHAT_USER_BANNED_PERIOD'		=> 'You are excluded from the chat until: %s',
	'CHAT_USER_BANNED_PERMANENT'	=> 'You are excluded from the chat permantly.',
	'CHAT_USER_ALREADY_EXISTS'		=> 'The user is already in use.',

	'CUSTOM_DATE'	=> 'Custom date',
	'EDIT'			=> 'Edit',
	'NEW_TOPIC'		=> 'New Topic',
	'PERMANENT'		=> 'Permanent',
	'QUOTE'			=> 'Quote',
	
	'HALF_AN_HOUR'	=> 'Half an hour',
	'NO_LIMIT'		=> 'No limit',
	'ONE_DAY'		=> 'One day',
	'ONE_HOUR'		=> 'One hour',
	'ONE_WEEK'		=> 'One week',
	'ONE_MONTH'		=> 'One month',
	'ONE_YEAR'		=> 'One year',
	'TWO_YEARS'		=> 'Two years',
));

// Text language
$lang = array_merge($lang, array());
