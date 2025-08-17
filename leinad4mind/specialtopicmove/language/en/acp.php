<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
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
//

$lang = array_merge($lang, [
	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'		=> 'Don’t show details about the move',
	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'		=> 'Show on first post of the thread',
	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'		=> 'Show on last post of the thread',
	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'		=> 'Show on last post at time of move',
	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
]);
