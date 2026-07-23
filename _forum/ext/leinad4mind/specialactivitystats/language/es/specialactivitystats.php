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
	'SPECIAL_ACTIVITY_STATS'         => 'Estadísticas de actividad',
	'SPECIAL_ACTIVITY_STATS_LATEST1' => 'Última a las',
	'SPECIAL_ACTIVITY_STATS_LATEST2' => '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS' => 'Nuevos temas <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'  => 'Nuevos mensajes <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'  => 'Nuevos usuarios <strong>%d</strong>',

	'SPECIAL_ACTIVITY_STATS_TOTAL' => [
		0 => 'En total hubo <strong>0</strong> usuarios conectados :: ',
		1 => 'En total hubo <strong>%d</strong> usuario conectado :: ',
		2 => 'En total hubo <strong>%d</strong> usuarios conectados :: ',
	],
	'SPECIAL_ACTIVITY_STATS_REG_USERS' => [
		0 => '0 registrados',
		1 => '%d registrado',
		2 => '%d registrados',
	],
	'SPECIAL_ACTIVITY_STATS_HIDDEN' => [
		0 => '0 ocultos',
		1 => '%d oculto',
		2 => '%d ocultos',
	],
	'SPECIAL_ACTIVITY_STATS_BOTS' => [
		0 => '0 robots',
		1 => '%d robot',
		2 => '%d robots',
	],
	'SPECIAL_ACTIVITY_STATS_GUESTS' => [
		0 => '0 invitados',
		1 => '%d invitado',
		2 => '%d invitados',
	],

	'SPECIAL_ACTIVITY_STATS_WORD'     => ' y',
	'SPECIAL_ACTIVITY_STATS_EXP'      => 'Los siguientes datos estan basados en usuarios activos hoy',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME' => [
		0 => 'Los siguientes datos estan basados en usuarios activos en estos momentos', // h=m=s=0
		1 => 'Los siguientes datos están basados en usuarios activos durante la última ', // first non zero value is 1
		2 => 'Los siguientes datos están basados en usuarios activos durante las últimas ', // first non zero value is >1
	],
	'SPECIAL_ACTIVITY_STATS_DAYS' => [
		0 => '',
		1 => '%%s %1$s día',
		2 => '%%s %1$s días',
	],
	'SPECIAL_ACTIVITY_STATS_HOURS' => [
		0 => '',
		1 => '%%s %1$s hora',
		2 => '%%s %1$s horas',
	],
	'SPECIAL_ACTIVITY_STATS_MINUTES' => [
		0 => '',
		1 => '%%s %1$s minuto',
		2 => '%%s %1$s minutos',
	],
	'SPECIAL_ACTIVITY_STATS_SECONDS' => [
		0 => '',
		1 => '%%s %1$s segundo',
		2 => '%%s %1$s segundos',
	],
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'    => 'La mayor cantidad de usuarios conectados fue <strong>%1$s</strong> el %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD' => 'La mayor cantidad de usuarios conectados fue <strong>%1$s</strong> entre %2$s y %3$s',
]);
