<?php

/**
 * @package Push Notifications for phpBB.
 * @copyright (c) 2017 - 2018 LavIgor
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
	'BROWSER_NOTIFICATION_BADGE_URL'            => 'URL absoluto para a imagem do emblema das Notificações Push',
	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrar o interruptor das Notificações Push do navegador no menu suspenso padrão das notificações',
	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'O interruptor das Notificações Push do navegador na página de gestão das opções de notificação será mostrado independentemente desta definição.',
	'BROWSER_NOTIFICATION_INTRO'                => 'Perguntar ao utilizador se pretende ativar as Notificações Push quando inicia sessão com um novo navegador',
	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'A janela modal será mostrada apenas uma vez em cada navegador, independentemente do número de inícios de sessão com esse navegador.',
	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Número máximo permitido de navegadores com as Notificações Push ativadas por utilizador',
	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'O utilizador não poderá ativar as Notificações Push para o fórum em nenhum navegador se o número permitido de navegadores com as Notificações Push ativadas tiver sido atingido. Insere 0 para desativar esta definição <em>(não recomendado)</em>.',
	'BROWSER_NOTIFICATION_TTL'                  => 'Tempo de Vida das Notificações Web',
	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'O Tempo de Vida (TTL) é o tempo durante o qual uma mensagem push é retida pelo serviço push (ex.: Mozilla) caso o navegador do utilizador ainda não esteja acessível (ex.: não esteja ligado). Poderás querer usar um tempo muito longo para notificações importantes. O TTL predefinido é de 4 semanas. No entanto, se enviares várias notificações não essenciais, define um TTL de 0: a notificação push só será entregue se o utilizador estiver atualmente ligado. Para outros casos, deverás usar um mínimo de um dia se os teus utilizadores tiverem vários fusos horários e, caso não tenham, bastarão algumas horas.',
]);
