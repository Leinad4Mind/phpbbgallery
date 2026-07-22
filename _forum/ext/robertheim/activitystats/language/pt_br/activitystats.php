<?php

/**
 * @package phpBB Extension - Activity Stats for phpBB.
 * @copyright (c) 2014 Robet Heim
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACTIVITY_STATS'     => 'Estatísticas de Atividade',
	'ACTIVITY_STATS_LATEST1' => 'última vez às',
	'ACTIVITY_STATS_LATEST2' => '',

	'ACTIVITY_STATS_NEW_TOPICS' => 'Novos tópicos <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_POSTS'  => 'Novos posts <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'  => 'Novos usuários <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL' => [
		0 => 'No total, havia <strong>0</strong> usuários online :: ',
		1 => 'No total, havia <strong>%d</strong> usuário online :: ',
		2 => 'No total, havia <strong>%d</strong> usuários online :: ',
	],
	'ACTIVITY_STATS_REG_USERS' => [
		0 => '0 registrados',
		1 => '%d registrado',
		2 => '%d registrados',
	],
	'ACTIVITY_STATS_HIDDEN' => [
		0 => '0 ocultos',
		1 => '%d oculto',
		2 => '%d ocultos',
	],
	'ACTIVITY_STATS_BOTS' => [
		0 => '0 bots',
		1 => '%d bot',
		2 => '%d bots',
	],
	'ACTIVITY_STATS_GUESTS' => [
		0 => '0 visitantes',
		1 => '%d visitante',
		2 => '%d visitantes',
	],

	'ACTIVITY_STATS_WORD' => ' e',
	'ACTIVITY_STATS_EXP'  => 'Os dados a seguir são baseados nos usuários ativos hoje',
	'ACTIVITY_STATS_EXP_TIME' => [
		0 => 'Os dados a seguir são baseados nos usuários ativos neste momento',
		1 => 'Os dados a seguir são baseados nos usuários ativos em um período de ',
		2 => 'Os dados a seguir são baseados nos usuários ativos em um período de ',
	],
	'ACTIVITY_STATS_DAYS' => [
		0 => '',
		1 => '%%s %1$s dia',
		2 => '%%s %1$s dias',
	],
	'ACTIVITY_STATS_HOURS' => [
		0 => '',
		1 => '%%s %1$s hora',
		2 => '%%s %1$s horas',
	],
	'ACTIVITY_STATS_MINUTES' => [
		0 => '',
		1 => '%%s %1$s minuto',
		2 => '%%s %1$s minutos',
	],
	'ACTIVITY_STATS_SECONDS' => [
		0 => '',
		1 => '%%s %1$s segundo',
		2 => '%%s %1$s segundos',
	],
	'ACTIVITY_STATS_RECORD_DAY'    => 'O máximo de usuários online em simultâneo foi <strong>%1$s</strong> em %2$s',
	'ACTIVITY_STATS_RECORD_PERIOD' => 'O máximo de usuários online em simultâneo foi <strong>%1$s</strong> entre %2$s e %3$s',
]);
