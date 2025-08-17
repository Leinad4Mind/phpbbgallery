<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
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
// Some characters you may want to copy&paste:
// ’ » “ ” …

$lang = array_merge($lang, [
	'TS_NAME'						=> 'Topic Statistics',
	'TS_ENABLED'					=> 'Enable Topic Statistics',
	'TS_VISIT'						=> 'Display number of visits',
	'TS_VISIT_EXPLAIN'				=> 'Show number of visits is the topic.',
	'TS_BOOKMARK'					=> 'Enable favorites',
	'TS_BOOKMARK_EXPLAIN'			=> 'Show the number of users that have added the topic to favorites.',
	'TS_BOOKMARK_USERS'				=> 'Show Favorites',
	'TS_BOOKMARK_USERS_EXPLAIN'		=> 'Show users who have added the topic to favorites.',
	'TS_FOLLOWERS'					=> 'Enable followers',
	'TS_FOLLOWERS_EXPLAIN'			=> 'Show the number of users who follow the topic.',
	'TS_FOLLOWERS_USERS'			=> 'Show followers',
	'TS_FOLLOWERS_USERS_EXPLAIN'	=> 'Show users who follow the topic.',
]);
