<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
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
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'INVALID_ANNOUNCEMENT_TOPIC'			=> 'The announcement topic is invalid.',
	'INVALID_GROUP_TOPIC'					=> 'The group topic is invalid.',
	'INVALID_WELCOME_TOPIC'					=> 'The welcome topic is invalid.',

	'LATEST'								=> 'Latest',

	'REDIRECT_ALWAYS'						=> 'Always redirect',
	'REDIRECT_ALWAYS_EXPLAIN'				=> 'Always redirect the user to the specified topic.',
	'REDIRECT_ANNOUNCE'						=> 'Announcement redirect on login',
	'REDIRECT_ANNOUNCE_EXPLAIN'				=> 'Redirect all users who have not logged in since the latest announcement was posted.',
	'REDIRECT_ANNOUNCE_MESSAGE_EXPLAIN'		=> 'Display a message to say that the user is being redirected to the latest announcement.',
	'REDIRECT_ANNOUNCE_OPTIONS'				=> 'Announcement options',
	'REDIRECT_ANNOUNCE_PRIORITY'			=> 'Redirect announcement priority',
	'REDIRECT_ANNOUNCE_PRIORITY_EXPLAIN'	=> 'Specify which announcement has priority',
	'REDIRECT_ANNOUNCE_TOPIC_ID'			=> 'Announcement topic ID',
	'REDIRECT_ANNOUNCE_TOPIC_ID_EXPLAIN'	=> 'Enter the ID of the announcement topic that you wish to redirect all users to.',
	'REDIRECT_ANY_ANNOUNCE_EXPLAIN'			=> 'Redirect all users who have not logged in since the specified announcement was posted.',

	'REDIRECT_ENABLE'						=> 'Enable',
	'REDIRECT_ENABLED'						=> 'User login redirect enable',

	'REDIRECT_GLOBAL'						=> 'Redirect to a Global announcement',
	'REDIRECT_GLOBAL_EXPLAIN'				=> 'Redirect the user to a Global announcement instead of a “normal” announcement.',
	'REDIRECT_GROUP'						=> 'Group topic redirect',
	'REDIRECT_GROUP_ALL'					=> 'All groups members',
	'REDIRECT_GROUP_ALL_EXPLAIN'			=> 'Setting this to Yes will override any individual group selected below.',
	'REDIRECT_GROUP_EXPLAIN'				=> 'Redirect members of a group, or all groups, to a specific topic upon logging in.',
	'REDIRECT_GROUP_ID'						=> 'Select group',
	'REDIRECT_GROUP_MESSAGE_EXPLAIN'		=> 'Display a message to say that the user is being redirected to a specific topic.',
	'REDIRECT_GROUP_OPTIONS'				=> 'Group options',
	'REDIRECT_GROUP_TOPIC_ID'				=> 'Group topic ID',
	'REDIRECT_GROUP_TOPIC_ID_EXPLAIN'		=> 'Enter the ID of the topic that you wish to redirect group members to.',

	'REDIRECT_LATEST_ANNOUNCE'				=> 'Latest announcement redirect on login',

	'REDIRECT_LOGIN'						=> 'Login redirect',
	'REDIRECT_LOGIN_EXPLAIN'				=> 'Here you can choose to have a new user redirected to a welcome topic upon their first log in after registering, have all users redirected to the latest announcement if they have not already seen it and/or redirect either all members or those from a selected group to a new message upon logging in.',

	'REDIRECT_SHOW_MESSAGE'					=> 'Show a redirect message',

	'REDIRECT_WELCOME'            			=> 'Welcome topic redirect',
	'REDIRECT_WELCOME_EXPLAIN'				=> 'Redirect all new users to a welcome topic upon first login to the board.',
	'REDIRECT_WELCOME_MESSAGE_EXPLAIN'		=> 'Display a message to say that the new user is being redirected to the welcome topic.',
	'REDIRECT_WELCOME_OPTIONS'				=> 'Welcome options',
	'REDIRECT_WELCOME_TOPIC_ID'				=> 'Welcome topic ID',
	'REDIRECT_WELCOME_TOPIC_ID_EXPLAIN'		=> 'Enter the ID of the welcome topic that you wish to redirect all new users to.',

	'SELECTED'								=> 'Selected',
));
