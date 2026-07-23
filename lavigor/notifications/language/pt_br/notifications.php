<?php

/**
 * @package Push Notifications for phpBB.
 * @copyright (c) 2017 - 2018 LavIgor
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Habilitar notificações de navegador.',
	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desabilitar notificações de navegador.',
	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso deseje se inscrever.',
	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Deseja permitir que o GoldTugAnime lhe envie notificações?',
	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por usuário) foi atingido. Por favor, desligue as notificações de navegador deste fórum que tenha ativado em qualquer outro navegador para que possa ativá-lo neste.',
	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo seu navegador atual.',
	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desabilitada neste navegador. Por favor, verifique sua conexão de internet e tente novamente. Entre em contato com o administrador do fórum se o problema persistir.',
]);
