<?php

/**
 * Simple Spoiler extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
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
	'SPOILER_DEPTH_LIMIT' => 'Profundidade máxima de spoilers aninhados',
	'SPOILER_DEPTH_LIMIT_EXPLAIN' => 'Profundidade máxima de spoilers aninhados numa mensagem. Defina como <samp>0</samp> para profundidade ilimitada.'
]);
