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
	'BROWSER_NOTIFICATION_BADGE_URL'            => 'URL absoluta para a imagem do selo das Notificações Push',
	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrar o interruptor das Notificações Push do navegador no menu suspenso padrão das notificações',
	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'O interruptor das Notificações Push do navegador na página de gerenciamento das opções de notificação será exibido independentemente desta configuração.',
	'BROWSER_NOTIFICATION_INTRO'                => 'Perguntar ao usuário se deseja ativar as Notificações Push ao fazer login em um novo navegador',
	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'A janela modal será exibida apenas uma vez em cada navegador, independentemente do número de logins com esse navegador.',
	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Número máximo permitido de navegadores com as Notificações Push ativadas por usuário',
	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'O usuário não poderá ativar as Notificações Push para o fórum em nenhum navegador se o número permitido de navegadores com as Notificações Push ativadas tiver sido atingido. Digite 0 para desativar esta configuração <em>(não recomendado)</em>.',
	'BROWSER_NOTIFICATION_TTL'                  => 'Tempo de Vida das Notificações Web',
	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'O Tempo de Vida (TTL) é o tempo durante o qual uma mensagem push é retida pelo serviço push (ex.: Mozilla) caso o navegador do usuário ainda não esteja acessível (ex.: não esteja conectado). Você pode querer usar um tempo bem longo para notificações importantes. O TTL padrão é de 4 semanas. Porém, se você enviar várias notificações não essenciais, defina um TTL de 0: a notificação push só será entregue se o usuário estiver conectado no momento. Para outros casos, você deve usar no mínimo um dia se os seus usuários tiverem vários fusos horários e, caso não tenham, algumas horas serão suficientes.',
]);
