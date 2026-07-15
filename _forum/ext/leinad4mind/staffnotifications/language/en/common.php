<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind
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
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, [
	'NOTIFICATION_GROUP_STAFFNOTIFICATIONS'			=> 'Staff Notifications',

	// delete_post
	'STAFFNOTIFICATIONS_DELETE_POST'				=> 'A post is deleted',
	'STAFFNOTIFICATIONS_TITLE_DELETE_POST'			=> '%1$s <strong>deleted a post</strong> by %2$s',

	// soft_delete_post
	'STAFFNOTIFICATIONS_SOFT_DELETE_POST'			=> 'A post is soft-deleted',
	'STAFFNOTIFICATIONS_TITLE_SOFT_DELETE_POST'		=> '%1$s <strong>soft-deleted a post</strong> by %2$s',

	// merge_topics
	'STAFFNOTIFICATIONS_MERGE_TOPICS'				=> 'Topics are merged',
	'STAFFNOTIFICATIONS_TITLE_MERGE_TOPICS'			=> '%1$s <strong>merged topics</strong>',

	// merge_posts
	'STAFFNOTIFICATIONS_MERGE_POSTS'				=> 'Posts are merged',
	'STAFFNOTIFICATIONS_TITLE_MERGE_POSTS'			=> '%1$s <strong>merged posts</strong>',

	// delete_post
	'STAFFNOTIFICATIONS_DELETE_TOPIC'				=> 'A topic is deleted',
	'STAFFNOTIFICATIONS_TITLE_DELETE_TOPIC'			=> '%1$s <strong>deleted a topic</strong> by %2$s',

	// soft_delete_post
	'STAFFNOTIFICATIONS_SOFT_DELETE_TOPIC'			=> 'A topic is soft-deleted',
	'STAFFNOTIFICATIONS_TITLE_SOFT_DELETE_TOPIC'	=> '%1$s <strong>soft-deleted a topic</strong> by %2$s',

	// ban_user
	'STAFFNOTIFICATIONS_BAN_USER'					=> 'A user is banned',
	'STAFFNOTIFICATIONS_TITLE_BAN_USER'				=> '%1$s <strong>banned user</strong> %2$s',

	'STAFFNOTIFICATIONS_REFERENCE_REASON'			=> 'Reason: %s',
	'STAFFNOTIFICATIONS_REFERENCE_SUBJECT'			=> 'Subject: %s',
	'STAFFNOTIFICATIONS_REFERENCE_TITLE'			=> 'Title: %s',
	'STAFFNOTIFICATIONS_REFERENCE_DURATION'			=> [
		0 => 'Duration: permanently',
		1 => 'Duration: %2$d minutes',
		2 => 'Duration: until %2$s',
	],
]);
