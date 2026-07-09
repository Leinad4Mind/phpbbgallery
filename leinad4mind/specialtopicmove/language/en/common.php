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
	'SPECIAL_TOPIC_MOVE_ENTER_REASON'			=> [
		1 => 'Please enter a reason for moving this topic',
		2 => 'Please enter a reason for moving these topics',
	],
	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'This topic was moved',
	'SPECIAL_TOPIC_MOVED_FROM'					=> 'from <strong>%s</strong>',
	'SPECIAL_TOPIC_MOVED_TO'					=> 'to <strong>%s</strong>',
	'SPECIAL_TOPIC_MOVED_BY'					=> 'by %s',
	'SPECIAL_TOPIC_MOVED_ON'					=> 'on %s.',
	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'a nonexistent user',
	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Move this topic back.',

	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Someone moves your topic.',
	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'Your topic “%1$s” was <strong>moved</strong> by %2$s to “%3$s”.',
]);
