<?php

/**
 * @package Push Notifications for phpBB.
 * @copyright (c) 2017 - 2018 LavIgor
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'LOG_WEB_PUSH_GENERAL_ERROR' => '<strong>Erro de Notificação Push</strong><br />» %s',
	'LOG_WEB_PUSH_SERVER_ERROR'  => '<strong>Erro de Notificação Push</strong> com o código <strong>%1$s</strong><br />» %2$s',
]);
