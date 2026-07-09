<?php

/**
 *
 * Profile Field Searchable. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
	'CPF_SEARCHABLE' => 'Searchable',
]);
