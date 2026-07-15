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
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, array(
	// Log entries (%1$s is replaced with the user name who triggered the event, %2$s is replaced with the room name)
	'LOG_MCHATROOMS_CREATED'		=> '<strong>mChat room created: ’%2$s’</strong><br />» %1$s',
	'LOG_MCHATROOMS_EDITED'			=> '<strong>mChat room edited</strong><br />» %1$s',
	'LOG_MCHATROOMS_DELETED'		=> '<strong>mChat room deleted: ’%2$s’</strong><br />» %1$s',
	'LOG_MCHATROOMS_DELETED_ALL'	=> '<strong>mChat rooms deleted</strong>',
));
