<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	$lang = array();
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
	'REDIRECT_ANNOUNCE'					=> 'Announcement redirect on login',
	'REDIRECT_ANNOUNCE_EXPLAIN'			=> 'Redirect all users who have not logged in since the latest announcement was posted.',
	'REDIRECT_ANNOUNCE_MESSAGE_EXPLAIN'	=> 'Display a message to say that the user is being redirected to the latest announcement.',
	'REDIRECT_ANNOUNCE_OPTIONS'			=> 'Announcement options',

	'REDIRECT_ENABLED'					=> 'User login redirect enable',

	'REDIRECT_GROUP'					=> 'Group topic redirect',
	'REDIRECT_GROUP_ALL'				=> 'All groups members',
	'REDIRECT_GROUP_ALL_EXPLAIN'		=> 'Setting this to Yes will override any individual group selected below.',
	'REDIRECT_GROUP_EXPLAIN'			=> 'Redirect members of a group, or all groups, to a specific topic upon logging in.',
	'REDIRECT_GROUP_ID'					=> 'Select group',
	'REDIRECT_GROUP_MESSAGE_EXPLAIN'	=> 'Display a message to say that the user is being redirected to a secific topic.',
	'REDIRECT_GROUP_OPTIONS'			=> 'Group options',
	'REDIRECT_GROUP_TOPIC_ID'			=> 'Group topic ID',
	'REDIRECT_GROUP_TOPIC_ID_EXPLAIN'	=> 'Enter the ID of the topic that you wish to redirect group members to.',

	'REDIRECT_LOGIN'					=> 'Login redirect',
	'REDIRECT_LOGIN_ANNOUNCE_TOPIC'		=> 'You have been successfully logged in. A new announcement has been posted since your last visit which you will now be redirected to.',
	'REDIRECT_LOGIN_EXPLAIN'			=> 'Here you can choose to have a new user redirected to a welcome topic upon their first log in after registering, have all users redirected to the latest announcement if they have not already seen it and/or redirect either all members or those from a selected group to a new message upon logging in.',
	'REDIRECT_LOGIN_GROUP_TOPIC'		=> 'You have been successfully logged in. A new group message has been posted since your last visit which you will now be redirected to.',
	'REDIRECT_LOGIN_WELCOME_TOPIC'		=> 'You have been successfully logged in. As this is your first visit you will now be redirected to our welcome topic.',

	'REDIRECT_REFRESH_ANNOUNCE'			=> '%sProceed to announcement topic%s',
	'REDIRECT_REFRESH_GROUP' 			=> '%sProceed to group topic%s',
	'REDIRECT_REFRESH_WELCOME'			=> '%sProceed to welcome topic%s',

	'REDIRECT_SHOW_MESSAGE'				=> 'Show a redirect message',

	'REDIRECT_WELCOME'            		=> 'Welcome topic redirect',
	'REDIRECT_WELCOME_EXPLAIN'			=> 'Redirect all new users to a welcome topic upon first login to the board.',
	'REDIRECT_WELCOME_MESSAGE_EXPLAIN'	=> 'Display a message to say that the new user is being redirected to the welcome topic.',
	'REDIRECT_WELCOME_OPTIONS'			=> 'Welcome options',
	'REDIRECT_WELCOME_TOPIC_ID'			=> 'Welcome topic ID',
	'REDIRECT_WELCOME_TOPIC_ID_EXPLAIN'	=> 'Enter the ID of the welcome topic that you wish to redirect all new users to.',



));
