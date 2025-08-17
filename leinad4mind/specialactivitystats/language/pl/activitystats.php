<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2015 HPK
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
	'SPECIAL_ACTIVITY_STATS'					=> 'Statystyki aktywności',
	'SPECIAL_ACTIVITY_STATS_LATEST1'			=> 'ostatnio o',
	'SPECIAL_ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS'			=> 'Nowych tematów: <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'			=> 'Nowych postów: <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'			=> 'Nowych użytkowników: <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'W sumie było <strong>0</strong> użytkowników online :: ',
		1		=> 'W sumie był <strong>%d</strong> użytkownik online :: ',
		2		=> 'W sumie było <strong>%d</strong> użytkowników online :: ',
	),
	'SPECIAL_ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 zarejestrowanych',
		1		=> '%d zarejestrowany',
		2		=> '%d zarejestrowanych',
	),
	'SPECIAL_ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 ukrytych',
		1		=> '%d ukryty',
		2		=> '%d ukrytych',
	),
	'SPECIAL_ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 botów',
		1		=> '%d bot',
		2		=> '%d boty',
	),
	'SPECIAL_ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 gości',
		1		=> '%d gość',
		2		=> '%d gości',
	),

	'SPECIAL_ACTIVITY_STATS_WORD'				=> ' i',
	'SPECIAL_ACTIVITY_STATS_EXP'				=> 'Poniższe dane są oparte na użytkownikach aktywnych dzisiaj',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'Poniższe dane pokazują użytkowników aktywnych teraz', // h=m=s=0
		1		=> 'Poniższe dane pokazują użytkowników aktywnych w ciągu ostatniej ', // first non zero value is 1
		2		=> 'Poniższe dane pokazują użytkowników aktywnych w ciągu ostatnich ', // first non zero value is >1
	),
	'SPECIAL_ACTIVITY_STATS_DAYS'				=> array(
		0		=> '',
		1		=> '%%s %1$s dnia',
		2		=> '%%s %1$s dni',
	),
	'SPECIAL_ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s godziny',
		2		=> '%%s %1$s godzin',
	),
	'SPECIAL_ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minuty',
		2		=> '%%s %1$s minut',
	),
	'SPECIAL_ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s sekundy',
		2		=> '%%s %1$s sekund',
	),
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'			=> 'Najwięcej użytkowników (<strong>%1$s</strong>) było online dnia %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD'		=> 'Najwięcej użytkowników (<strong>%1$s</strong>) było online między %2$s a %3$s',
]);
