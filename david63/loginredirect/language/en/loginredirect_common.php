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
	'REDIRECT_LOGIN_ANNOUNCE_TOPIC'	=> 'You have been successfully logged in. A new announcement has been posted since your last visit which you will now be redirected to.',
	'REDIRECT_LOGIN_GROUP_TOPIC'	=> 'You have been successfully logged in. A new group message has been posted since your last visit which you will now be redirected to.',
	'REDIRECT_LOGIN_WELCOME_TOPIC'	=> 'You have been successfully logged in. As this is your first visit you will now be redirected to our welcome topic.',

	'REDIRECT_REFRESH_ANNOUNCE'		=> '%sProceed to announcement topic%s',
	'REDIRECT_REFRESH_GROUP' 		=> '%sProceed to group topic%s',
	'REDIRECT_REFRESH_WELCOME'		=> '%sProceed to welcome topic%s',
));
