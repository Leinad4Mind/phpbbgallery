<?php

/**
 * @package Popup PM for phpBB.
 * @copyright (c) Татьяна5
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'POPUPPM_YOU_NEW_PM_BLINK' => [
		1 => '<<<! Recebeste uma nova mensagem privada !>>>',
		2 => '<<<! Tens %s novas mensagens privadas !>>>',
	],
	'POPUPPM_YOU_NEW_PM' => [
		1 => 'Tens uma nova mensagem privada',
		2 => 'Tens %s novas mensagens privadas',
	],
]);
