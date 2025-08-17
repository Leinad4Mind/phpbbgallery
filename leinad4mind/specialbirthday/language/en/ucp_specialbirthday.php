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
	'BAN_REASON'						=> 'Under age',

	'ENTER_BIRTHDATE' 					=> 'Enter your birthdate',

	'REGISTRATION_AGE_ERROR'			=> 'The age entered is %1$s. The minimum age on this board is %2$s.',
	'REGISTRATION_AGE_MISSING'			=> 'Invalid birthdate data entered.',

	'REGISTRATION_AGE_REQUIRED'			=> 'You must enter your birthday.',
	'REGISTRATION_AGE_CANNOT_CHANGE'	=> 'You cannot change your birthday.',
	'REGISTRATION_AGE_PROFILE'			=> 'Who can see my age',
	'REGISTRATION_AGE_EVERYBODY'		=> 'Everybody',
	'REGISTRATION_AGE_NOBODY'			=> 'Nobody',
	'REGISTRATION_AGE_FRIENDS'			=> 'Only my friends',
));
