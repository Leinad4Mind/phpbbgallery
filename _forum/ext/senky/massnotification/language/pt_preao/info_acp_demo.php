<?php

/**
 * Mass Notification. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019, Jakub Senko
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
	'ACP_SENKY_MASSNOTIFICATION_TITLE' => 'Notificação em massa',
]);
