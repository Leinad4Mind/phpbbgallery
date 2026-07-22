<?php

/**
 * @package phpBB Extension - Activity Stats for phpBB.
 * @copyright (c) 2014 Robet Heim
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACTIVITY_STATS_NEW_POSTS'  => 'Novas mensagens <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'  => 'Novos utilizadores <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL' => [
		0 => 'No total, estavam <strong>0</strong> utilizadores online :: ',
		1 => 'No total, estava <strong>%d</strong> utilizador online :: ',
		2 => 'No total, estavam <strong>%d</strong> utilizadores online :: ',
	],
	'ACTIVITY_STATS_REG_USERS' => [
		0 => '0 registados',
		1 => '%d registado',
		2 => '%d registados',
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
	'ACTIVITY_STATS_EXP'  => 'Os dados seguintes baseiam-se nos utilizadores activos hoje',
	'ACTIVITY_STATS_EXP_TIME' => [
		0 => 'Os dados seguintes baseiam-se nos utilizadores activos neste momento',
		1 => 'Os dados seguintes baseiam-se nos utilizadores activos num período de ',
		2 => 'Os dados seguintes baseiam-se nos utilizadores activos num período de ',
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
	'ACTIVITY_STATS_RECORD_DAY'    => 'O máximo de utilizadores online em simultâneo foi <strong>%1$s</strong> em %2$s',
	'ACTIVITY_STATS_RECORD_PERIOD' => 'O máximo de utilizadores online em simultâneo foi <strong>%1$s</strong> entre %2$s e %3$s',
]);
