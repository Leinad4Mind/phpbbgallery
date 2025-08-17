<?php

/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
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
	'ACP_USER_UTILS'					=> 'User utilities',

	'REGISTRATION_AGE'					=> 'Special Birthdate',
	'REGISTRATION_AGE_LOG'				=> '<strong>Special Birthdate Settings Updated</strong>',
	'REGISTRATION_AGE_MANAGE'			=> 'Manage Special Birthdate',
	'REGISTRATION_AGE_LOG_FAIL'			=> '<strong>Birthdate check failed</strong><br>» %1$s entered an age of %2$s',
	'REGISTRATION_AGE_CHANGED'			=> '<strong>Birthday changed</strong><br>» from %1$s to %2$s',
	'REGISTRATION_AGE_CHANGE_ATTEMPT'	=> '<strong>Attempted to change birthday</strong><br>» to %1$s, age: %2$d',
));
