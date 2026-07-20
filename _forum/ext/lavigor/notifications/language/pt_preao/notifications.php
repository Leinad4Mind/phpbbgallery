<?php

/**
 * @package Push Notifications for phpBB.
 * @copyright (c) 2017 - 2018 LavIgor
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Ativar notificações de navegador.',
	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desactivar notificações de navegador.',
	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso desejes te subscrever.',
	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Desejas permitir que o GoldTugAnime te envie notificações?',
	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por utilizador) foi atingido. Por favor, desliga as notificações de navegador deste fórum que tenhas ativado em qualquer outro navegador para que possas ativá-lo neste.',
	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo teu navegador actual.',
	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desativada neste navegador. Por favor, verifica a tua conexão de internet e tenta novamente. Entra em contacto com o administrador do fórum se o problema persistir.',
]);
