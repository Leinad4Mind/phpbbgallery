<?php
/** 
* main.php [English [En]]
* @package cBB Chat
* @version v1.2.0 02/03/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
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
	'CHAT_APPLY'				=> 'Apply',
	'CHAT_ARCHIVE'				=> 'Chat archive',
	'CHAT_BAN_DATE'				=> 'End of exclusion',
	'CHAT_BAN_DATE_EXPLAIN'		=> 'The valid format is DD/MM/YYYY hh:mm:ss.',
	'CHAT_BAN_PERIOD'			=> 'Exclusion duration',
	'CHAT_BAN_USER'				=> 'Exclude',
	'CHAT_BBCODE'				=> 'BBcodes',
	'CHAT_CANCEL'				=> 'Cancel',
	'CHAT_CLEAR_BBCODE'			=> 'Delete BBcode',
	'CHAT_CLEAR_INPUT'			=> 'Delete all',
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
	
	'CHAT_LOAD_MORE'			=> 'Load more',
	'CHAT_SUBMIT'				=> 'Accept',
	'CHAT_TIP'					=> 'Tip',
	'CHAT_UNBAN_USER'			=> 'Remove exclusion',
	'CHAT_USER_BANNED_PERIOD'		=> 'You are excluded from the chat until: %s',
	'CHAT_USER_BANNED_PERMANENT'	=> 'You are excluded from the chat permanently.',
	'CHAT_USER_ALREADY_EXISTS'		=> 'The user is already in use.',
	'CHAT_VIEW_HISTORY'				=> 'See previous messages',

	'BATCH_ACTIONS'		=> 'Batch actions',
	'CUSTOM_DATE'		=> 'Custom date',
	'EDIT'				=> 'Edit',
	'NEW_TOPIC'			=> 'New Topic',
	'PERMANENT'			=> 'Permanent',
	'QUOTE'				=> 'Quote',
	
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
