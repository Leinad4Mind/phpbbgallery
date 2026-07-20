<?php

/**
 * This file is part of the phpBB Forum Software package.
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * For full copyright and license information, please see
 * the docs/CREDITS.txt file.
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

$lang = array_merge($lang, [
	'SORRY_AUTH_READ_OTHER'        => 'Não tens permissão para ler este tópico.',
	'SORRY_CLASSIFIED_INFORMATION' => 'Informação confidencial',
]);
