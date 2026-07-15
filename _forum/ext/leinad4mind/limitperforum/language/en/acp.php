<?php

/**
 *
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
	'LIMIT_PER_FORUM'				=> 'Limit Posts per Forum',
	'FORUM_MAX_POSTS'				=> 'Maximum count of posts per user',
	'FORUM_MAX_POSTS_SHORT'			=> 'Post limit',
	'FORUM_MAX_TOPICS'				=> 'Maximum count of topics per user',
	'FORUM_MAX_TOPICS_SHORT'		=> 'Topic limit',
	'FORUM_MAX_GROUPS'				=> 'Group limits',
	'FORUM_MAX_GROUPS_EXPLAIN'		=> 'Group limits override the limits above. Set hours to 0 to disable time limit.',
	'FORUM_MAX_TOPICS_EXPLAIN'		=> 'Should be lower than the maximum post count unless if it is set to 0',
	'FORUM_MAX_TOPICS_ERROR'		=> 'The maximum of topic per forums should be lower than the maximum of post per forums',
	'FORUM_MAX_TP_EXPLAIN'			=> 'Set 0 to disable. Set hours to 0 to disable time limit.',
	'LIMIT_POSTS_PER_FORUM_TOPICS'	=> 'topics',
	'LIMIT_POSTS_PER_FORUM_POSTS'	=> 'posts',
	'LIMIT_POSTS_PER_FORUM_EVERY'	=> 'every',
	'LIMIT_POSTS_PER_FORUM_HOURS'	=> 'hours',
]);
