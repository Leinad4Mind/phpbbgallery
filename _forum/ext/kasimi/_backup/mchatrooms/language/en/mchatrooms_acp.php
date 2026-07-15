<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, [
	'MCHATROOMS_SETTINGS'						=> 'mChat Rooms',
	'MCHATROOMS_MAX_ROOMS'						=> 'Global maximum number of rooms',
	'MCHATROOMS_MAX_ROOMS_EXPLAIN'				=> 'Limit the total number of rooms that can be created. This allows the administrator to prevent flooding when users are allowed to create rooms.<br><em>Set to 0 to allow an unlimited number of rooms. Default is 10 rooms.</em>',
	'MCHATROOMS_MAX_PRIVATE_ROOMS'				=> 'Maximum number of private rooms per user',
	'MCHATROOMS_MAX_PRIVATE_ROOMS_EXPLAIN'		=> 'Limit the total number of private rooms that each user can join. This allows the administrator to force a user to leave old and unused rooms.<br><em>Set to 0 to allow a user to join an unlimited number of private rooms. Default is 10 rooms.</em>',
	'MCHATROOMS_ROOMS'							=> 'rooms',

	'MCHATROOMS_INVITE_EXPIRATION'				=> 'Invites expire after',
	'MCHATROOMS_INVITE_EXPIRATION_EXPLAIN'		=> 'Number of minutes after an invite becomes invalid. A user cannot be invited to a room while an invite for this room is still valid. Only after the invite has expired, the user can be invited to the room again.<br><em>Set to 0 to disable, but note that users could be flooded with invites. Default is 15 minutes.</em>',
	'MCHATROOMS_MINUTES'						=> 'minutes',

	'MCHATROOMS_MAX_INVITES'					=> 'Maximum number of invites',
	'MCHATROOMS_MAX_INVITES_EXPLAIN'			=> 'Number of invites a user can send within the above expiration time.<br><em>Set to 0 to allow unlimited invites. Default is 10 invites.</em>',
	'MCHATROOMS_INVITES'						=> 'invites',

	'MCHATROOMS_POST_NOTIFICATIONS'				=> 'Room for new topic notification messages',
	'MCHATROOMS_QUOTE_NOTIFICATIONS'			=> 'Room for quote notification messages',
	'MCHATROOMS_EDIT_NOTIFICATIONS'				=> 'Room for edit notification messages',
	'MCHATROOMS_REPLY_NOTIFICATIONS'			=> 'Room for reply notification messages',
	'MCHATROOMS_LOGIN_NOTIFICATIONS'			=> 'Room for new login notification messages',

	'MCHATROOMS_PRUNE_SKIP_LOBBY'				=> 'Exclude lobby from message pruning',
	'MCHATROOMS_PRUNE_SKIP_LOBBY_EXPLAIN'		=> 'If set to yes, messages in the lobby are <strong>not pruned</strong>.',
	'MCHATROOMS_PRUNE_SKIP_PUBLIC'				=> 'Exclude public rooms from message pruning',
	'MCHATROOMS_PRUNE_SKIP_PUBLIC_EXPLAIN'		=> 'If set to yes, messages in public rooms other than the lobby are <strong>not pruned</strong>.',
	'MCHATROOMS_PRUNE_SKIP_PROTECTED'			=> 'Exclude protected rooms from message pruning',
	'MCHATROOMS_PRUNE_SKIP_PROTECTED_EXPLAIN'	=> 'If set to yes, messages in password-protected rooms are <strong>not pruned</strong>.',
	'MCHATROOMS_PRUNE_SKIP_PRIVATE'				=> 'Exclude private rooms from message pruning',
	'MCHATROOMS_PRUNE_SKIP_PRIVATE_EXPLAIN'		=> 'If set to yes, messages in private rooms are <strong>not pruned</strong>.',

	'MCHATROOMS_PURGE_ROOM'						=> 'Delete all messages in the selected room now',
	'MCHATROOMS_PURGE_ROOM_EXPLAIN'				=> 'For founders only. Only public and password-protected rooms can be purged. Private rooms cannot be purged.',
	'MCHATROOMS_PURGED_ROOM'					=> 'All messages in the room “%1$s” have been deleted.',

	'MCHATROOMS_DELETE'							=> 'Delete all rooms now',
	'MCHATROOMS_DELETE_EXPLAIN'					=> 'For founders only. This will delete all public, password-protected and private rooms including their messages, except for the lobby.',
	'MCHATROOMS_DELETE_CONFIRM'					=> 'Confirm deleting all rooms',
	'MCHATROOMS_DELETED'						=> 'All mChat rooms have been deleted.',

	'MCHAT_ROOMS_ENABLED'						=> 'Display rooms',
	'MCHAT_ROOMS_ENTER_ALL'						=> 'Join all public rooms automatically',

	'MCHATROOMS_DISABLE_WARNING' 				=> '<p style="color: red; font-size: 2em; margin-top: 1em;">Attention!</p><strong style="color:red;">When disabling this extension, messages from all rooms become visible for all users.</strong><br><br>Therefore it is highly recommended to either:<ul><li>disable the mChat extension before disabling the mChat Rooms add-on extension, or</li><li>manually delete all rooms before disabling the mChat Rooms add-on extension.</li></ul>',
	'MCHATROOMS_DELETE_DATA_WARNING'			=> '<p style="font-size: 2em; margin-top: 1em;">Attention!</p><div style="font-size: .9em; margin-top: 1em;">Before deleting mChat extension data, it is strongly recommended to delete data of the mChat Rooms add-on extension. Leaving data of the mChat Rooms add-on extension in the database will cause errors when:<br><br><ul><li>deleting data of the mChat Rooms add-on extension without mChat being installed</li><li>later installing the mChat extension again</li></ul></div>',
]);
