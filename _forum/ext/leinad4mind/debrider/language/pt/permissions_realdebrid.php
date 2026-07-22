<?php

/**
 * Debrider extension for the phpBB Forum Software package.
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
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

$lang = array_merge($lang, [
	'ACL_M_DEBRIDERCANENABLE'      => 'Pode ativar debrider',
	'ACL_U_DEBRIDERCANGENERATEURL' => 'Pode usar botão de gerar url premium debrid',
]);
