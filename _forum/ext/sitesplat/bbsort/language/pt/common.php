<?php

/**
 * BBsort. An extension for the phpBB Forum Software package.
 * @copyright (c) 2017, Sitesplat
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'BBSORT'         => 'BBSort',
	'BBSORT_SORT_BY' => 'Ordenar tópicos por',
]);
