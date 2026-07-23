<?php

/**
 * This file is part of the phpBB Forum Software package.
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * For full copyright and license information, please see
 * the docs/CREDITS.txt file.
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
	'TIME_TO_READ' => [
		1 => '1 min de leitura',
		2 => '%d min de leitura'
	],
]);
