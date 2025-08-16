<?php

/**
 *
 * Best Answer. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, kinerity, https://www.layer-3.org
 * @copyright (c) 2017, Leinad4Mind, https://leinad4mind.top/forum
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
	'ANSWERED'				=> 'ANSWERED',

	'BEST_ANSWER'			=> 'BEST ANSWER',
	'BUTTON_MARK_ANSWER'	=> 'Mark Answer',
	'BUTTON_UNMARK_ANSWER'	=> 'Unmark Answer',

	'ENABLE_BEST_ANSWER'			=> 'Enable "Best Answer" feature',
	'ENABLE_BEST_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the "best answer".',
	'EXTENSION_NOT_ENABLED'			=> 'The Best Answer extension is not enabled on this forum.',

	'BBPOINTS_BEST_ANSWER'			=> 'Amount of BBpoints for "Best Answer" post',
	'BBPOINTS_BEST_ANSWER_EXPLAIN'	=> 'Set the number of BBpoints to be credited to post author when his post in this forum is marked as "Best Answer"',

	'FULL_POST'			=> 'GO TO FULL POST',

	'INVALID_FILTER'	=> 'The filter parameter is invalid. Please verify this variable is correct.',

	'LOG_MARK_ANSWER'	=> '<strong>Marked post as best answer</strong><br />» %1$s by %2$s',
	'LOG_UNMARK_ANSWER'	=> '<strong>Unmarked post as best answer</strong><br />» %1$s by %2$s',

	'LOG_ADD_BBPOINTS_MARK_ANSWER'		=> '<strong>Added bbpoints to author for best answer</strong><br />» %1$s by %2$s',
	'LOG_REMOVE_BBPOINTS_MARK_ANSWER'	=> '<strong>Removed bbpoints of author for best answer</strong><br />» %1$s by %2$s',

	'MARK_ANSWER'			=> 'Mark post as best answer',
	'MARK_ANSWER_CONFIRM'	=> 'Are you sure you want to mark this post as the best answer?',

	'UNMARK_ANSWER'			=> 'Unmark post as best answer',
	'UNMARK_ANSWER_CONFIRM'	=> 'Are you sure you want to unmark this post as the best answer?',
	
	'SEARCH_USER_ANSWERS'	=> 'Search user’s answers',

	'TOPIC_FIRST_POST'		=> 'You cannot mark this post as the best answer as it is the first post of the topic.',
	'TOPICS_ANSWERED'		=> 'Topics answered',

	'BESTANSWER_NOTIFICATION'			=> '%1$s marked your post <br/>in topic “%2$s” as best answer',
	'NOT_BESTANSWER_NOTIFICATION'		=> '%1$s unmarked your post <br/>in topic “%2$s” as best answer',
	'NOTIFICATION_TYPE_BESTANSWER' 		=> 'Someone marks your topic reply as the "best answer"',
	'NOTIFICATION_TYPE_NOTBESTANSWER'	=> 'Someone unmarks your topic reply as the "best answer"',
));
