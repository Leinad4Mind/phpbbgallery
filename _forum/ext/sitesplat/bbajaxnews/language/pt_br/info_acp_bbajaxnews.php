<?php

/**
 * @package BBajaxnews for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'BBAJAXNEWS' => 'BBAjaxNews',

	'ACP_BBAJAXNEWS_TITLE'         => 'BBajaxnews',
	'ACP_BBAJAXNEWS_TITLE_EXPLAIN' => 'Aqui pode configurar tudo sobre a extensão BBAjaxNews.',
	'ACP_BBAJAXNEWS_SETTING_SAVED' => 'As configurações do BBajaxnews foram guardadas.',

	'SPECIAL'         => 'Notícias Especiais',
	'CASUAL'          => 'Notícias Casuais',
	'SPECIAL_EXPLAIN' => 'Os eventos de notícias especiais são acionados quando um critério específico é satisfeito. EX: registro de usuário, novo tópico, Novo anúncio, etc. (Veja abaixo as notícias incluídas).',
	'CASUAL_EXPLAIN'  => 'Os eventos de notícias casuais são acionados após um usuário não receber nenhuma outra notícia ao vivo por um período especificado de tempo (configurável abaixo).',

	'SITESPLAT_BBAJAXNEWS_DRIVER'         => 'Driver',
	'SITESPLAT_BBAJAXNEWS_DRIVER_EXPLAIN' => 'Selecione na lista de fornecedores qual driver pretende utilizar. Diferentes fornecedores têm preços diferentes, mas também disponibilidade, suporte diferente, etc.',
	'DRIVER_PUSHER'                       => 'Pusher',
	'DRIVER_PUBNUB'                       => 'PubNub',

	'SITESPLAT_BBAJAXNEWS_PUBNUB_PUB'         => 'Chave de Publicação PubNub',
	'SITESPLAT_BBAJAXNEWS_PUBNUB_PUB_EXPLAIN' => 'Pode encontrar a sua Chave de Publicação PubNub na <a href="https://admin.pubnub.com/" target="_blank">Administração PubNub</a>.',
	'SITESPLAT_BBAJAXNEWS_PUBNUB_SUB'         => 'Chave de Subscrição PubNub',
	'SITESPLAT_BBAJAXNEWS_PUBNUB_SUB_EXPLAIN' => 'Pode encontrar a sua Chave de Subscrição PubNub na <a href="https://admin.pubnub.com/" target="_blank">Administração PubNub</a>.',

	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_KEY'             => 'Chave da App Pusher',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_KEY_EXPLAIN'     => 'Pode encontrar a sua Chave da App Pusher no <a href="https://dashboard.pusher.com/" target="_blank">Painel do Pusher</a>.',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_SEC'             => 'Segredo da App Pusher',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_SEC_EXPLAIN'     => 'Pode encontrar o Segredo da App Pusher no <a href="https://dashboard.pusher.com/" target="_blank">Painel do Pusher</a>.',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_ID'              => 'ID da App Pusher',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_ID_EXPLAIN'      => 'Pode encontrar o ID da App Pusher no <a href="https://dashboard.pusher.com/" target="_blank">Painel do Pusher</a>.',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_CLUSTER'         => 'Cluster Pusher',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_CLUSTER_EXPLAIN' => 'Pode encontrar o seu Cluster Pusher no <a href="https://dashboard.pusher.com/" target="_blank">Painel do Pusher</a>.',

	'SITESPLAT_BBAJAXNEWS_INTERVAL'                        => 'Intervalo entre notícias casuais ao vivo',
	'SITESPLAT_BBAJAXNEWS_INTERVAL_EXPLAIN'                => 'Quando não é apresentada nenhuma notícia ao usuário por um determinado número de minutos, uma das notícias casuais ser-lhe-á apresentada. Introduza 0 para desabilitar notícias casuais.',
	'SITESPLAT_BBAJAXNEWS_NOTY_VISIBILITY_CONTROL'         => 'Controlo de visibilidade',
	'SITESPLAT_BBAJAXNEWS_NOTY_VISIBILITY_CONTROL_EXPLAIN' => 'Isto irá mostrar/acionar a BBnews apenas quando o usuário estiver ativamente a navegar no fórum. Nota: isto é uma funcionalidade API do navegador (<a href="https://developer.mozilla.org/en-US/docs/Web/API/Page_Visibility_API" target="_blank">Page Visibility API</a>).',
	'SITESPLAT_BBAJAXNEWS_NOTY_TIMEOUT'                    => 'Atraso de encerramento',
	'SITESPLAT_BBAJAXNEWS_NOTY_TIMEOUT_EXPLAIN'            => 'Defina os milissegundos após os quais a notícia será fechada. EX: 5000 significa que a notícia será fechada após 5 segundos. Defina como 0 para notícias permanentes (apenas fechará por ação do usuário).',
	'SITESPLAT_BBAJAXNEWS_NOTY_PROGRESS_BAR'               => 'Exibir uma barra de progresso',
	'SITESPLAT_BBAJAXNEWS_NOTY_PROGRESS_BAR_EXPLAIN'       => 'Defina como Sim para apresentar uma barra de progresso indicando o tempo que falta para a notícia encerrar. <br/>Nota: uma barra de progresso apenas estará disponível se a opção de "Atraso de encerramento" estiver em uso.',
	'SITESPLAT_BBAJAXNEWS_NOTY_LAYOUT'                     => 'Posição da Notificação',
	'SITESPLAT_BBAJAXNEWS_NOTY_LAYOUT_EXPLAIN'             => 'Selecione a posição da notificação',
	'SITESPLAT_BBAJAXNEWS_NOTY_MO'                         => 'Utilizar animação mo.js',
	'SITESPLAT_BBAJAXNEWS_NOTY_MO_EXPLAIN'                 => 'Isto usará uma animação extravagante via JavaScript, mas requer o carregamento de um arquivo JS adicional. <br/>(Aprox: 35.4kB Minified + Gzipped) Ele já se encontra incluído no BBajaxNews e pode usá-lo imediatamente se optar por habilitar a animação.',
	'LAYOUT_TOP'                                           => 'Topo',
	'LAYOUT_TOPLEFT'                                       => 'Topo Esquerda',
	'LAYOUT_TOPCENTER'                                     => 'Topo Centro',
	'LAYOUT_TOPRIGHT'                                      => 'Topo Direita',
	'LAYOUT_CENTER'                                        => 'Centro',
	'LAYOUT_CENTERLEFT'                                    => 'Centro Esquerda',
	'LAYOUT_CENTERRIGHT'                                   => 'Centro Direita',
	'LAYOUT_BOTTOM'                                        => 'Fundo',
	'LAYOUT_BOTTOMLEFT'                                    => 'Fundo Esquerda',
	'LAYOUT_BOTTOMCENTER'                                  => 'Fundo Centro',
	'LAYOUT_BOTTOMRIGHT'                                   => 'Fundo Direita',

	'SITESPLAT_BBAJAXNEWS_BBDONATION'        => 'Habilitar notícias ao vivo quando um usuário fizer uma doação (requer extensão BBdonation)',
	'SITESPLAT_BBAJAXNEWS_BBMEMBERSHIP'      => 'Habilitar notícias ao vivo quando um usuário adquirir uma associação (requer extensão BBmembership)',
	'SITESPLAT_BBAJAXNEWS_BBVOTE'            => 'Habilitar notícias ao vivo quando for marcada a melhor resposta (requer extensão BBvote)',
	'SITESPLAT_BBAJAXNEWS_FRIEND_LOGGED_IN'  => 'Habilitar notícias ao vivo quando o amigo de um usuário efetuar o login',
	'SITESPLAT_BBAJAXNEWS_NEW_ANNOUNCEMENT'  => 'Habilitar notícias ao vivo quando um tópico for definido como anúncio (global)',
	'SITESPLAT_BBAJAXNEWS_NEW_STICKY'        => 'Habilitar notícias ao vivo quando um tópico for definido como fixo',
	'SITESPLAT_BBAJAXNEWS_NEW_TOPIC'         => 'Habilitar notícias ao vivo quando um novo tópico for criado',
	'SITESPLAT_BBAJAXNEWS_USER_JOINED_BOARD' => 'Habilitar notícias ao vivo quando um novo usuário se juntar ao fórum',
	'SITESPLAT_BBAJAXNEWS_USER_JOINED_GROUP' => 'Habilitar notícias ao vivo quando os usuários forem adicionados ao grupo especial',

	'SITESPLAT_BBAJAXNEWS_NEW_POSTS_TODAY'  => 'Habilitar notícias ao vivo informando sobre o número de publicações postadas hoje até ao momento',
	'SITESPLAT_BBAJAXNEWS_RANDOM_POLL'      => 'Habilitar notícias ao vivo encorajando o usuário a participar numa sondagem aleatória onde ainda não votou',
	'SITESPLAT_BBAJAXNEWS_USERS_ONLINE_24H' => 'Habilitar notícias ao vivo informando o número de usuários conectados nas últimas 24h',
	'SITESPLAT_BBAJAXNEWS_USERS_ONLINE'     => 'Habilitar notícias ao vivo informando o número de usuários conectados',

	'LOG_BBAJAXNEWS_PUBLISH_FAIL' => '<strong>Publicação BBAjaxNews do tipo »%s« falhou</strong><br />» %s',

	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBAJAXNEWS_NOTICE' => '<div class="phpinfo"><p>As definições desta extensão encontram-se sob a aba "Extensões".</p></div>',
]);
