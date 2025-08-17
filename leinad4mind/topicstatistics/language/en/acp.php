<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB')) {
   exit;
}

if (empty($lang) || !is_array($lang)) {
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
   'TS_NAME'                             => 'Topic Statistics',
   'TS_TOPICS_ENABLED'                   => 'Enable Topic Statistics',
   'TS_USER_LIMIT_MAX'                   => 'Maximum amount of users to display',
   'TS_USER_LIMIT_MAX_EXPLAIN'           => 'Limits the amount of users to display enhancing performance in forums with a lot of users',
   'TS_USER_PROFILE_LINK'                => 'Display user profile link',
   'TS_USER_PROFILE_LINK_EXPLAIN'        => 'Add user profile link to the username',
   'TS_TOPICS_VISIT'                     => 'Display number of visits on topics',
   'TS_TOPICS_VISIT_EXPLAIN'             => 'Show number of visits to the topic.',
   'TS_TOPICS_BOOKMARK'                  => 'Enable favorites on topics',
   'TS_TOPICS_BOOKMARK_EXPLAIN'          => 'Show the number of users that have added the topic to favorites.',
   'TS_TOPICS_BOOKMARK_USERS'            => 'Show favorites on topics',
   'TS_TOPICS_BOOKMARK_USERS_EXPLAIN'    => 'Show users who have added the topic to favorites.',
   'TS_TOPICS_BOOKMARK_AVATARS'          => 'Show favorites avatars on topics',
   'TS_TOPICS_BOOKMARK_AVATARS_EXPLAIN'  => 'If "Show favorites" is enabled, also display their avatars.',
   'TS_TOPICS_FOLLOWERS'                 => 'Enable followers on topics',
   'TS_TOPICS_FOLLOWERS_EXPLAIN'         => 'Show the number of users who follow the topic.',
   'TS_TOPICS_FOLLOWERS_USERS'           => 'Show followers on topics',
   'TS_TOPICS_FOLLOWERS_USERS_EXPLAIN'   => 'Show users who follow the topic.',
   'TS_TOPICS_FOLLOWERS_AVATARS'         => 'Show follower avatars on topics',
   'TS_TOPICS_FOLLOWERS_AVATARS_EXPLAIN' => 'If "Show followers on topics" is enabled, also display their avatars.',
   'TS_FORUMS_ENABLED'                   => 'Enable Forum Statistics',
   'TS_FORUMS_VISIT'                     => 'Display number of visits on forums',
   'TS_FORUMS_VISIT_EXPLAIN'             => 'Show number of visits to the topic.',
   'TS_FORUMS_FOLLOWERS'                 => 'Enable followers on forums',
   'TS_FORUMS_FOLLOWERS_EXPLAIN'         => 'Show the number of users who follow the forum.',
   'TS_FORUMS_FOLLOWERS_USERS'           => 'Show followers on forums',
   'TS_FORUMS_FOLLOWERS_USERS_EXPLAIN'   => 'Show users who follow the forum.',
   'TS_FORUMS_FOLLOWERS_AVATARS'         => 'Show follower avatars on forums',
   'TS_FORUMS_FOLLOWERS_AVATARS_EXPLAIN' => 'If "Show followers on forums" is enabled, also display their avatars.',
]);