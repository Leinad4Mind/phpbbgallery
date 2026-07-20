<?php

/**
 * @package phpBB Extension - Activity Stats for phpBB.
 * @copyright (c) 2014 Robet Heim
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACTIVITY_STATS_USERS_TOTAL'             => 'Um total de %1$s utilizadores conectados',
	'ACTIVITY_STATS_USERS_TOTAL_GUESTS'      => ' (%1$s registados, %2$s ocultos e %3$s visitantes)',
	'ACTIVITY_STATS_USERS_ZERO_TOTAL'        => 'Um total de 0 utilizadores conectados',
	'ACTIVITY_STATS_USERS_ZERO_TOTAL_GUESTS' => ' (0 registados, 0 ocultos e 0 visitantes)',

	'ACTIVITY_STATS_NEW_TOPICS' => [
		0 => '0 novos tópicos',
		1 => '1 novo tópico',
		2 => '%1$s novos tópicos',
	],
	'ACTIVITY_STATS_NEW_POSTS' => [
		0 => '0 novas publicações',
		1 => '1 nova publicação',
		2 => '%1$s novas publicações',
	],
	'ACTIVITY_STATS_NEW_USERS' => [
		0 => '0 novos utilizadores',
		1 => '1 novo utilizador',
		2 => '%1$s novos utilizadores',
	],

	'ACTIVITY_STATS_PERIOD_EXP' => 'Baseado na atividade de %s',

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
