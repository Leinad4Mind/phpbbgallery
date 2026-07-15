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
	'ACP_PERMISSIONS_CAT_MCHATROOMS'	=> 'mChat Rooms',

	'ACL_U_MCHATROOMS_VIEW'				=> 'Can see mChat rooms',
	'ACL_U_MCHATROOMS_CREATE'			=> 'Can create mChat rooms',
	'ACL_U_MCHATROOMS_CREATE_PRIVATE'	=> 'Can create private mChat rooms',
	'ACL_U_MCHATROOMS_INVITE'			=> 'Can invite users to mChat rooms',
	'ACL_U_MCHATROOMS_EDIT_OWN'			=> 'Can edit own mChat rooms',
	'ACL_U_MCHATROOMS_EDIT_ALL'			=> 'Can edit any mChat room',
	'ACL_U_MCHATROOMS_DELETE_OWN'		=> 'Can delete own mChat rooms',
	'ACL_U_MCHATROOMS_DELETE_ALL'		=> 'Can delete any mChat room',
	'ACL_U_MCHATROOMS_PROTECTED'		=> 'Can see/create/edit/delete password-protected mChat rooms (requires the respective permission)',
	'ACL_U_MCHATROOMS_MASTERKEY'		=> 'Can join/edit/delete password-protected mChat rooms without providing the password (requires the respective permission)',
	'ACL_U_MCHATROOMS_KICK'				=> 'Can kick users from password-protected and private rooms',
	'ACL_U_MCHATROOMS_SORT'				=> 'Can sort mChat rooms',

	'ACL_U_MCHAT_ROOMS_ENABLED'			=> 'Can customise <em>Display rooms</em>',
	'ACL_U_MCHAT_ROOMS_ENTER_ALL'		=> 'Can customise <em>Join all rooms automatically</em>',
]);
