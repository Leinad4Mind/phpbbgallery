<?php

/**
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'SPECIAL_ACTIVITY_STATS'            => 'Estatísticas de Atividade',
	'SPECIAL_ACTIVITY_STATS_LATEST1'    => 'último às',
	'SPECIAL_ACTIVITY_STATS_LATEST2'    => '',
	'SPECIAL_ACTIVITY_STATS_NEW_TOPICS' => 'Novos tópicos <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_POSTS'  => 'Novas mensagens <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_NEW_USERS'  => 'Novos utilizadores <strong>%d</strong>',
	'SPECIAL_ACTIVITY_STATS_TOTAL'      => [
		0 => 'No total havia <strong>0</strong> utilizadores online :: ',
		1 => 'No total havia <strong>%d</strong> utilizador online :: ',
		2 => 'No total havia <strong>%d</strong> utilizadores online :: ',
	],
	'SPECIAL_ACTIVITY_STATS_REG_USERS' => [
		0 => '0 registados',
		1 => '%d registado',
		2 => '%d registados',
	],
	'SPECIAL_ACTIVITY_STATS_HIDDEN' => [
		0 => '0 ocultos',
		1 => '%d oculto',
		2 => '%d ocultos',
	],
	'SPECIAL_ACTIVITY_STATS_BOTS' => [
		0 => '0 bots',
		1 => '%d bot',
		2 => '%d bots',
	],
	'SPECIAL_ACTIVITY_STATS_GUESTS' => [
		0 => '0 visitantes',
		1 => '%d visitante',
		2 => '%d visitantes',
	],
	'SPECIAL_ACTIVITY_STATS_WORD'     => ' e',
	'SPECIAL_ACTIVITY_STATS_EXP'      => 'Os dados seguintes baseiam-se nos utilizadores ativos hoje',
	'SPECIAL_ACTIVITY_STATS_EXP_TIME' => [
		0 => 'Os dados seguintes baseiam-se nos utilizadores ativos agora mesmo',
		1 => 'Os dados seguintes baseiam-se nos utilizadores ativos nas últimas ',
		2 => 'Os dados seguintes baseiam-se nos utilizadores ativos nas últimas ',
	],
	'SPECIAL_ACTIVITY_STATS_DAYS' => [
		0 => '',
		1 => '%%s %1$s dia',
		2 => '%%s %1$s dias',
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
	'SPECIAL_ACTIVITY_STATS_RECORD_DAY'    => 'O maior número de utilizadores online foi <strong>%1$s</strong> em %2$s',
	'SPECIAL_ACTIVITY_STATS_RECORD_PERIOD' => 'O maior número de utilizadores online foi <strong>%1$s</strong> entre %2$s e %3$s',
]);
