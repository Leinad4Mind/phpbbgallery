<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2015 ForumsFaciles
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
	'SPECIAL_ACTIVITY_STATS'					=> 'Statistiques d’activité',
	'SPECIAL_ACTIVITY_STATS_LATEST1'			=> 'dernière connexion le',
	'SPECIAL_ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS'			=> 'Nouveau(x) sujet(s) : <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'			=> 'Nouveau(x) message(s) : <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'			=> 'Nouveau(x) membre(s) : <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'Il n’y avait <strong>aucun</strong> utilisateur en ligne : ',
		1		=> 'Il y avait <strong>%d</strong> utilisateur en ligne : ',
		2		=> 'Il y avait <strong>%d</strong> utilisateurs en ligne : ',
	),
	'SPECIAL_ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> 'aucun membre',
		1		=> '%d membre',
		2		=> '%d membres',
	),
	'SPECIAL_ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> 'aucun masqué',
		1		=> '%d masqué',
		2		=> '%d masqués',
	),
	'SPECIAL_ACTIVITY_STATS_BOTS'				=> array(
		0		=> 'aucun robot',
		1		=> '%d robot',
		2		=> '%d robots',
	),
	'SPECIAL_ACTIVITY_STATS_GUESTS'				=> array(
		0		=> 'aucun invité',
		1		=> '%d invité',
		2		=> '%d invités',
	),

	'SPECIAL_ACTIVITY_STATS_WORD'				=> ' et',
	'SPECIAL_ACTIVITY_STATS_EXP'				=> 'Les données suivantes sont basées sur les utilisateurs actifs d’aujourd’hui',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'Les données suivantes sont basées sur les utilisateurs actifs à l’instant', // d=h=m=s=0
		1		=> 'Les données suivantes sont basées sur les utilisateurs actifs durant la dernière ', // first non zero value is 1
		2		=> 'Les données suivantes sont basées sur les utilisateurs actifs durant les dernières ', // first non zero value is >1
	),
	'SPECIAL_ACTIVITY_STATS_DAYS'				=> array(
		0		=> '',
		1		=> '%%s %1$s jour',
		2		=> '%%s %1$s jours',
	),
	'SPECIAL_ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s heure',
		2		=> '%%s %1$s heures',
	),
	'SPECIAL_ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minute',
		2		=> '%%s %1$s minutes',
	),
	'SPECIAL_ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s seconde',
		2		=> '%%s %1$s secondes',
	),
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'			=> 'Le nombre maximum d’utilisateurs en ligne était de <strong>%1$s</strong> le %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD'		=> 'Le nombre maximum d’utilisateurs en ligne était de <strong>%1$s</strong> entre le %2$s et le %3$s',
]);
