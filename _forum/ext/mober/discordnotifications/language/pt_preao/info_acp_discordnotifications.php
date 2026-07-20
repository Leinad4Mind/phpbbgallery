<?php

/**
 * @copyright (c) 2024
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
	'ACP_DISCORD_NOTIFICATIONS'               => 'Notificações do Discord',
	'ACP_DISCORD_NOTIFICATIONS_TITLE'         => 'Configurações das Notificações do Discord',
	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'    => 'Modificou configurações das notificações do Discord',
	'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR' => 'Webhook do Discord retornou o código de estado HTTP %d',
	'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR'    => 'Erro cURL do Webhook do Discord código %d',
	'ACP_DISCORD_NOTIFICATIONS_JSON_ERROR'    => 'Erro no JSON encode do Discord: %s',
]);
