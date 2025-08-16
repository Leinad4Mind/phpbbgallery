<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'MASSNOTIFICATION_DESC'	=> 'Here you can send a board notification to either all of your users or specific users or groups.',

	'COMPOSE'				=> 'Compose mass notification',
	'ALL_USERS'				=> 'All users',
	'SEND_TO_GROUP'			=> 'Send to group',
	'SEND_TO_USERS'			=> 'Send to users',
	'SEND_TO_USERS_EXPLAIN'	=> 'Entering names here will override any group selected above. Enter each username on a new line.',
	'TITLE'					=> 'Notification title',
	'MESSAGE_EXPLAIN'		=> 'Keep it short, preferably below 150 characters. You may use HTML.',
	'URL'					=> 'Redirect URL',
	'URL_EXPLAIN'			=> 'Enter URL to which user will be redirected after clicking on the notification.',
	'AUTHOR_EXPLAIN'		=> 'Enter author of the notification. Leave blank for generic notification without author.',
	'SEND_NOTIFICATION'		=> 'Send notification',

	'NO_NOTIFICATION_TITLE'		=> 'You have to specify notification title.',
	'NO_NOTIFICATION_MESSAGE'	=> 'You have to specify notification message.',
	'NO_NOTIFICATION_AUTHOR'	=> 'Author does not exist.',

	'NOTIFICATION_SEND'	=> 'Your notification has been sent.',
));
