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
	'SPECIAL_ACTIVITY_STATS'					=> 'Statistiche Attive',
	'SPECIAL_ACTIVITY_STATS_LATEST1'			=> 'alle',
	'SPECIAL_ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS'			=> 'Nuovi argomenti <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'			=> 'Nuovi messaggi <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'			=> 'Nuovi utenti <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'In totale ci sono stati <strong>0</strong> utenti in line : ',
		1		=> 'In totale c\'&egrave; stato <strong>%d</strong> utente in linea : ',
		2		=> 'In totale ci sono stati <strong>%d</strong> utenti in linea : ',
	),
	'SPECIAL_ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 registrati',
		1		=> '%d registrato',
		2		=> '%d registrati',
	),
	'SPECIAL_ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 nascosti',
		1		=> '%d nascosto',
		2		=> '%d nascosti',
	),
	'SPECIAL_ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 bots',
		1		=> '%d bot',
		2		=> '%d bots',
	),
	'SPECIAL_ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 ospiti',
		1		=> '%d ospite',
		2		=> '%d ospiti',
	),

	'SPECIAL_ACTIVITY_STATS_WORD'				=> ' and',
	'SPECIAL_ACTIVITY_STATS_EXP'				=> 'I seguenti dati si basano sugli utenti attivi oggi',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'The following data is based on users active right now', // h=m=s=0
		1		=> 'The following data is based on users active over the past ', // first non zero value is 1
		2		=> 'The following data is based on users active over the past ', // first non zero value is >1
	),
	'SPECIAL_ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s ora',
		2		=> '%%s %1$s ore',
	),
	'SPECIAL_ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minuto',
		2		=> '%%s %1$s minuti',
	),
	'SPECIAL_ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s secondo',
		2		=> '%%s %1$s secondi',
	),
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'			=> 'Record di utenti connessi giornalmente &egrave; stato di <strong>%1$s</strong> il %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD'		=> 'Record di utenti connessi &egrave; stato di <strong>%1$s</strong> tra il %2$s ed il %3$s',
]);
