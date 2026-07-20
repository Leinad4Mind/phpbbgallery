<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'MARTTIPHPBB_SHOWPHPBBEVENTS_SHOW'            => 'Mostrar',
	'MARTTIPHPBB_SHOWPHPBBEVENTS_SHOW_EXPLAIN'    => 'Mostrar eventos do phpBB',
	'MARTTIPHPBB_SHOWPHPBBEVENTS_HIDE'            => 'Esconder',
	'MARTTIPHPBB_SHOWPHPBBEVENTS_HIDE_EXPLAIN'    => 'Esconder eventos do phpBB',
	'MARTTIPHPBB_SHOWPHPBBEVENTS_PHP_EVENT_NAME'  => 'Evento PHP',
	'MARTTIPHPBB_SHOWPHPBBEVENTS_PHP_EVENT_COUNT' => 'Contagem',
	'MARTTIPHPBB_SHOWPHPBBEVENTS_SINCE'           => 'Desde',
	'MARTTIPHPBB_SHOWPHPBBEVENTS_FILENAME'        => 'Nome do Ficheiro',
]);
