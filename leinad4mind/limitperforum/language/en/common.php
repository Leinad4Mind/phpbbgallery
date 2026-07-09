<?php

/**
 *
 * Limit Posts per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, kasimi, https://kasimi.net
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
	'ERROR_POST_COUNT'			=> [
		1 => 'You cannot post a new post here, because you have reached your limit of 1 allowed post in this forum.',
		2 => 'You cannot post a new post here, because you have reached your limit of %1$d allowed posts in this forum.',
	],
	'ERROR_POST_COUNT_TIME'	=> [
		1 => 'You cannot post a new post here, because you have reached your limit of 1 allowed post every %2$d hour(s) in this forum.',
		2 => 'You cannot post a new post here, because you have reached your limit of %1$d allowed posts every %2$d hour(s) in this forum.',
	],
	'ERROR_TOPIC_COUNT'			=> [
		1 => 'You cannot post a new topic here, because you have reached your limit of 1 allowed topic in this forum.',
		2 => 'You cannot post a new topic here, because you have reached your limit of %1$d allowed topics in this forum.',
	],
	'ERROR_TOPIC_COUNT_TIME'	=> [
		1 => 'You cannot post a new topic here, because you have reached your limit of 1 allowed topic every %2$d hour(s) in this forum.',
		2 => 'You cannot post a new topic here, because you have reached your limit of %1$d allowed topics every %2$d hour(s) in this forum.',
	],
	'ERROR_POST_REST'			=> [
		1 => 'You have <strong class="error">1</strong> free post on this forum before being disallowed to post new posts.',
		2 => 'You have <strong class="error">%1$d</strong> free posts on this forum before being disallowed to post new posts.',
	],
	'ERROR_TOPIC_REST'			=> [
		1 => 'You have <strong class="error">1</strong> free topic on this forum before being disallowed to post new topics.',
		2 => 'You have <strong class="error">%1$d</strong> free topics on this forum before being disallowed to post new topics.',
	],
	'ERROR_POST_TOPIC_REST'		=> 'You have <strong class="error">%1$d</strong> free topic and <strong class="error">%2$d</strong> free post on this forum before being disallowed to post.',
	'ERROR_POSTS_TOPIC_REST'	=> 'You have <strong class="error">%1$d</strong> free topic and <strong class="error">%2$d</strong> free posts on this forum before being disallowed to post.',
	'ERROR_POST_TOPICS_REST'	=> 'You have <strong class="error">%1$d</strong> free topics and <strong class="error">%2$d</strong> free post on this forum before being disallowed to post.',
	'ERROR_POSTS_TOPICS_REST'	=> 'You have <strong class="error">%1$s</strong> free topics and <strong class="error">%2$s</strong> free posts on this forum before being disallowed to post.',
]);
