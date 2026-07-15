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
	'MCHATROOMS_HEADER'						=> 'Rooms',
	'MCHATROOMS_NOT_EXIST'					=> 'This room does not exist',
	'MCHATROOMS_SESSION_EXPIRED'			=> 'Your session has expired. Please reload the page and login.',
	'MCHATROOMS_CREATE'						=> 'New room',
	'MCHATROOMS_CREATE_LIMIT_ERROR'			=> 'Failed to create room. Maximum number of rooms reached.',
	'MCHATROOMS_PRIVATE_CREATE_LIMIT_ERROR'	=> 'Failed to create private room. You have joined too many private rooms. Please leave a private room and try again.',
	'MCHATROOMS_PRIVATE_JOIN_LIMIT_ERROR'	=> 'Failed to join private room. You have joined too many private rooms. Please leave a private room and try again.',
	'MCHATROOMS_NAME'						=> 'Room name',
	'MCHATROOMS_PASSWORD'					=> 'Password',
	'MCHATROOMS_PASSWORD_CURRENT'			=> 'Current password',
	'MCHATROOMS_PASSWORD_NEW'				=> 'New password',
	'MCHATROOMS_PASSWORD_NEW_EXPLAIN'		=> 'Empty to leave unchanged.',
	'MCHATROOMS_PASSWORD_CONFIRM'			=> 'Confirm password',
	'MCHATROOMS_PASSWORD_NEW_CONFIRM'		=> 'Confirm new password',
	'MCHATROOMS_PASSWORD_WRONG'				=> 'You provided the wrong password.',
	'MCHATROOMS_PASSWORD_EMPTY'				=> 'The password is empty.',
	'MCHATROOMS_PASSWORD_MISMATCH'			=> 'The password confirmation did not match.',
	'MCHATROOMS_PASSWORD_CHANGE'			=> 'Change password',
	'MCHATROOMS_TYPE'						=> 'Room type',
	'MCHATROOMS_PUBLIC'						=> 'Public room',
	'MCHATROOMS_PROTECTED'					=> 'Password protected room',
	'MCHATROOMS_PRIVATE'					=> 'Private room',
	'MCHATROOMS_PRIVATE_EXPLAIN'			=> 'Only users with an invite can see and join a private room. When all users have left a private room, it is deleted.',
	'MCHATROOMS_ARCHIVE_PROTECTED'			=> '%1$s (password protected)',
	'MCHATROOMS_ARCHIVE_PRIVATE'			=> '%1$s (private)',
	'MCHATROOMS_JOINING'					=> 'You are joining the room <strong>{room}</strong>.',
	'MCHATROOMS_DENIED'						=> 'Wrong password',
	'MCHATROOMS_ENTER'						=> 'Join room',
	'MCHATROOMS_LEAVE'						=> 'Leave room',
	'MCHATROOMS_LOADING'					=> 'Loading messages…',
	'MCHATROOMS_EMPTY'						=> 'Be the first to post a message in this room!',
	'MCHATROOMS_EDIT'						=> 'Edit room',
	'MCHATROOMS_OWNER'						=> 'Owner',
	'MCHATROOMS_OWNER_EXPLAIN'				=> 'The user who created this room.',
	'MCHATROOMS_DEL'						=> 'Delete room',
	'MCHATROOMS_DEL_CONFIRM'				=> 'Attention: This room and all messages in it are deleted!',
	'MCHATROOMS_KICK'						=> 'Kick user',
	'MCHATROOMS_SOUND_ENABLED'				=> 'Sound for new messages in this room is enabled',
	'MCHATROOMS_SOUND_DISABLED'				=> 'Sound for new messages in this room is disabled',
	'MCHATROOMS_NEW_MESSAGES'				=> 'New messages!',
	'MCHATROOMS_INVITE'						=> 'Invite users',
	'MCHATROOMS_INVITE_ROOM'				=> 'Invite to room',
	'MCHATROOMS_INVITE_USERNAMES'			=> 'Users to invite',
	'MCHATROOMS_INVITE_USERNAMES_EXPLAIN'	=> 'One username per line.',
	'MCHATROOMS_INVITE_MESSAGE'				=> 'Message for invited users',
	'MCHATROOMS_OWNER_INVITE'				=> 'Owner invite only',
	'MCHATROOMS_OWNER_INVITE_EXPLAIN'		=> 'If set to yes, only you can invite other users.',
	'MCHATROOMS_INVITE_SELF'				=> 'You cannot invite yourself.',
	'MCHATROOMS_USERS_INVITED_MESSAGE'		=> 'You invited %1$s to the room “%2$s”.',
	'MCHATROOMS_AND'						=> ' and ',
	'MCHATROOMS_USERS_INVITED_TITLE'		=> [
		1	=> 'One user invited',
		2	=> '%d users invited',
	],
	'MCHATROOMS_INVITE_EXPIRE'				=> [
		0	=> 'The invites will not expire.',
		1	=> 'The invites will expire in 1 minute.',
		2	=> 'The invites will expire in %1$d minutes.',
	],
	'MCHATROOMS_INVITE_NOT_FOUND'			=> [
		1	=> 'The requested user %2$s does not exist.',
		2	=> 'The requested users %2$s do not exist.',
	],
	'MCHATROOMS_INVITE_ACTIVE'				=> [
		1	=> '%2$s has already been invited.',
		2	=> '%2$s have already been invited.',
	],
	'MCHATROOMS_INVITE_NO_ROOMS_PERMISSION'	=> [
		1	=> '%2$s either does not have permission to see rooms or has rooms disabled.',
		2	=> '%2$s either do not have permission to see rooms or have rooms disabled.',
	],
	'MCHATROOMS_INVITE_MAX'					=> [
		0	=> 'You cannot invite any more users at the moment. Please try again later.',
		1	=> 'You can only invite one user at the moment.',
		2	=> 'You can only invite up to %1$d users at the moment.',
	],
	'MCHATROOMS_USERS'						=> [
		0 => 'There are no users in the room “%2$s”',
		1 => 'There is one user in the room “%2$s”',
		2 => 'There are %1$d users in the room “%2$s”',
	],
	'MCHATROOMS_JOINED_TIME'				=> [
		0 => 'invite pending',
		1 => 'joined %2$s',
	],
	'MCHATROOMS_ARCHIVE'					=> 'Select room',
]);
