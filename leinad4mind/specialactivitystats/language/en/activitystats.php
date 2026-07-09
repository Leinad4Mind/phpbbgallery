<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
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
	// for the normal sites
	'SPECIAL_ACTIVITY_STATS'					=> 'Activity Statistics',
	'SPECIAL_ACTIVITY_STATS_LATEST1'			=> 'last at',
	'SPECIAL_ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS'			=> 'New topics <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'			=> 'New posts <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'			=> 'New users <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'In total there were <strong>0</strong> users online :: ',
		1		=> 'In total there was <strong>%d</strong> user online :: ',
		2		=> 'In total there were <strong>%d</strong> users online :: ',
	),
	'SPECIAL_ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 registered',
		1		=> '%d registered',
		2		=> '%d registered',
	),
	'SPECIAL_ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 hidden',
		1		=> '%d hidden',
		2		=> '%d hidden',
	),
	'SPECIAL_ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 bots',
		1		=> '%d bot',
		2		=> '%d bots',
	),
	'SPECIAL_ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 guests',
		1		=> '%d guest',
		2		=> '%d guests',
	),

	'SPECIAL_ACTIVITY_STATS_WORD'				=> ' and',
	'SPECIAL_ACTIVITY_STATS_EXP'				=> 'The following data is based on users active today',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'The following data is based on users active right now', // d=h=m=s=0
		1		=> 'The following data is based on users active over the past ', // first non zero value is 1
		2		=> 'The following data is based on users active over the past ', // first non zero value is >1
	),
	'SPECIAL_ACTIVITY_STATS_DAYS'				=> array(
		0		=> '',
		1		=> '%%s %1$s day',
		2		=> '%%s %1$s days',
	),
	'SPECIAL_ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s hour',
		2		=> '%%s %1$s hours',
	),
	'SPECIAL_ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minute',
		2		=> '%%s %1$s minutes',
	),
	'SPECIAL_ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s second',
		2		=> '%%s %1$s seconds',
	),
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'			=> 'Most users ever online was <strong>%1$s</strong> on %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD'		=> 'Most users ever online was <strong>%1$s</strong> between %2$s and %3$s',
]);
