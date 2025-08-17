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
	'SPECIAL_ACTIVITY_STATS'					=> 'Aktivitäts Statistiken',
	'SPECIAL_ACTIVITY_STATS_LATEST1'			=> 'zuletzt um',
	'SPECIAL_ACTIVITY_STATS_LATEST2'			=> ' Uhr',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS'			=> 'Neue Themen <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'			=> 'Neue Beiträge <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'			=> 'Neue Benutzer <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'Insgesamt waren <strong>0</strong> Benutzer online :: ',
		1		=> 'Insgesamt war <strong>%d</strong> Benutzer online :: ',
		2		=> 'Insgesamt waren <strong>%d</strong> Benutzer online :: ',
	),
	'SPECIAL_ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 Registrierte',
		1		=> '%d Registrierter',
		2		=> '%d Registrierte',
	),
	'SPECIAL_ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 Unsichtbare',
		1		=> '%d Unsichtbarer',
		2		=> '%d Unsichtbare',
	),
	'SPECIAL_ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 Bots',
		1		=> '%d Bot',
		2		=> '%d Bots',
	),
	'SPECIAL_ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 Gäste',
		1		=> '%d Gast',
		2		=> '%d Gäste',
	),

	'SPECIAL_ACTIVITY_STATS_WORD'				=> ' und',
	'SPECIAL_ACTIVITY_STATS_EXP'				=> 'Die folgenden Daten basieren auf den heutigen Aktivitäten',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'Die folgenden Daten basieren auf den Benutzer Aktivitäten gerade jetzt', // h=m=s=0
		1		=> 'Die folgenden Daten basieren auf den Benutzer Aktivitäten seit ', // first non zero value is 1
		2		=> 'Die folgenden Daten basieren auf den Benutzer Aktivitäten seit ', // first non zero value is >1
	),
	'SPECIAL_ACTIVITY_STATS_DAYS'				=> array(
		0		=> '',
		1		=> '%%s %1$s Tag',
		2		=> '%%s %1$s Tage',
	),
	'SPECIAL_ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s Stunde',
		2		=> '%%s %1$s Stunden',
	),
	'SPECIAL_ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s Minute',
		2		=> '%%s %1$s Minuten',
	),
	'SPECIAL_ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s Sekunde',
		2		=> '%%s %1$s Sekunden',
	),
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'			=> 'Der bisherige Rekord von <strong>%1$s</strong> Besuchern war am %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD'		=> 'Der absolute Besucher Rekord liegt bei <strong>%1$s</strong> zwischen %2$s und %3$s',
]);
