<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2015 Rembert Oldenboom
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
	'SPECIAL_ACTIVITY_STATS'					=> 'Activiteitenstatistieken',
	'SPECIAL_ACTIVITY_STATS_LATEST1'			=> 'laatste om',
	'SPECIAL_ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS'			=> 'Nieuwe onderwerpen <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'			=> 'Nieuwe berichten <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'			=> 'Nieuwe gebruikers <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'In totaal waren er <strong>0</strong> gebruikers online :: ',
		1		=> 'In totaal was er <strong>%d</strong> gebruiker online :: ',
		2		=> 'In totaal waren er <strong>%d</strong> gebruikers online :: ',
	),
	'SPECIAL_ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 geregistreerd',
		1		=> '%d geregistreerd',
		2		=> '%d geregistreerd',
	),
	'SPECIAL_ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 verborgen',
		1		=> '%d verborgen',
		2		=> '%d verborgen',
	),
	'SPECIAL_ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 bots',
		1		=> '%d bot',
		2		=> '%d bots',
	),
	'SPECIAL_ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 gasten',
		1		=> '%d gast',
		2		=> '%d gasten',
	),

	'SPECIAL_ACTIVITY_STATS_WORD'				=> ' en',
	'SPECIAL_ACTIVITY_STATS_EXP'				=> 'De onderstaande data is gebaseerd op de actieve gebruikers vandaag',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'De onderstaande data is gebaseerd op de actieve gebruikers op dit moment', // d=h=m=s=0
		1		=> 'De onderstaande data is gebaseerd op de actieve gebruikers over de afgelopen ', // first non zero value is 1
		2		=> 'De onderstaande data is gebaseerd op de actieve gebruikers over de afgelopen ', // first non zero value is >1
	),
	'SPECIAL_ACTIVITY_STATS_DAYS'				=> array(
		0		=> '',
		1		=> '%%s %1$s dag',
		2		=> '%%s %1$s dagen',
	),
	'SPECIAL_ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s uur',
		2		=> '%%s %1$s uren',
	),
	'SPECIAL_ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minuut',
		2		=> '%%s %1$s minuten',
	),
	'SPECIAL_ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s seconde',
		2		=> '%%s %1$s seconden',
	),
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'			=> 'Het grootste aantal gebruikers ooit online was <strong>%1$s</strong> op %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD'		=> 'Het grootste aantal gebruikers online tussen %2$s en %3$s was <strong>%1$s</strong>',
]);
