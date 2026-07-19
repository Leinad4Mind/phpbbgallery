<?php

/**
 * Simple Spoiler extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @ignore
 */
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'SPOILER_DEPTH_LIMIT'         => 'Número máximo de spoilers dentro de outros spoilers',
	'SPOILER_DEPTH_LIMIT_EXPLAIN' => 'Número máximo de spoilers dentro de outros spoilers. Defina <samp>0</samp> para um valor ilimitado.'
]);
