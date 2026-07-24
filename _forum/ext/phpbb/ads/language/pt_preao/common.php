<?php

/**
 * Advertisement management. An extension for the phpBB Forum Software package.
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
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
	'ADBLOCKER_TITLE'   => 'Bloqueador de anúncios detetado',
	'ADBLOCKER_MESSAGE' => [
		1 => 'O nosso website é possível graças à exibição de anúncios online aos nossos visitantes. Por favor, considere apoiar-nos desativando o seu bloqueador de anúncios no nosso website.',
		2 => 'O nosso website é possível graças à exibição de anúncios online aos nossos visitantes. Desative o seu bloqueador de anúncios para continuar a usar o nosso website.',
	],
	'ADVERTISEMENT'                => 'Anúncio',
	'HIDE_AD'                      => 'Ocultar anúncio',
	'VISUAL_DEMO'                  => 'A demonstração visual para os locais dos anúncios está ativa',
	'DISABLE_VISUAL_DEMO'          => 'Clique para desactivar a demonstração visual',
	'DISABLE_VISUAL_DEMO_ERROR'    => 'Houve um problema a concluir o seu pedido. Por favor tente desactivar a demonstração visual novamente.',
	'AD_ABOVE_HEADER'              => 'Acima do cabeçalho',
	'AD_ABOVE_HEADER_DESC'         => 'Mostrado em cada página antes do cabeçalho.',
	'AD_BELOW_HEADER'              => 'Abaixo do cabeçalho',
	'AD_BELOW_HEADER_DESC'         => 'Mostrado em cada página depois do cabeçalho (e antes da barra de navegação).',
	'AD_BEFORE_POSTS'              => 'Antes das mensagens',
	'AD_BEFORE_POSTS_DESC'         => 'Mostrado na página do tópico antes da primeira mensagem.',
	'AD_AFTER_POSTS'               => 'Depois das mensagens',
	'AD_AFTER_POSTS_DESC'          => 'Mostrado na página do tópico depois da última mensagem (e também depois da Resposta Rápida, se ativada).',
	'AD_BEFORE_QUICKREPLY'         => 'Antes da Resposta Rápida',
	'AD_BEFORE_QUICKREPLY_DESC'    => 'Mostrado na página do tópico antes do editor da Resposta Rápida.',
	'AD_AFTER_QUICKREPLY'          => 'Depois da Resposta Rápida',
	'AD_AFTER_QUICKREPLY_DESC'     => 'Mostrado na página do tópico depois do editor da Resposta Rápida.',
	'AD_BELOW_FOOTER'              => 'Abaixo do rodapé',
	'AD_BELOW_FOOTER_DESC'         => 'Mostrado em cada página depois do rodapé.',
	'AD_ABOVE_FOOTER'              => 'Acima do rodapé',
	'AD_ABOVE_FOOTER_DESC'         => 'Mostrado em cada página antes do rodapé.',
	'AD_AFTER_FIRST_POST'          => 'Depois da primeira mensagem',
	'AD_AFTER_FIRST_POST_DESC'     => 'Mostrado na página do tópico depois da primeira mensagem.',
	'AD_AFTER_NOT_FIRST_POST'      => 'Depois de cada mensagem exceto a primeira',
	'AD_AFTER_NOT_FIRST_POST_DESC' => 'Mostrado na página do tópico depois de cada mensagem exceto a primeira.',
	'AD_BEFORE_PROFILE'            => 'Antes do perfil do utilizador',
	'AD_BEFORE_PROFILE_DESC'       => 'Mostrado antes do conteúdo da página de perfil do membro.',
	'AD_AFTER_PROFILE'             => 'Depois do perfil do utilizador',
	'AD_AFTER_PROFILE_DESC'        => 'Mostrado depois do conteúdo da página de perfil do membro.',
	'AD_AFTER_HEADER_NAVBAR'       => 'Depois da barra de navegação do cabeçalho',
	'AD_AFTER_HEADER_NAVBAR_DESC'  => 'Mostrado em cada página depois da barra de navegação do cabeçalho.',
	'AD_AFTER_FOOTER_NAVBAR'       => 'Depois da barra de navegação do rodapé',
	'AD_AFTER_FOOTER_NAVBAR_DESC'  => 'Mostrado em cada página depois da barra de navegação do rodapé.',
	'AD_POP_UP'                    => 'Pop-up',
	'AD_POP_UP_DESC'               => 'Mostrado uma vez por dia quando o utilizador visita este fórum como caixa sobreposta. O utilizador tem de fechar esta caixa para continuar. Tenha em atenção que este tipo de anúncio é muito intrusivo! Este local não suporta código JavaScript.',
	'AD_SLIDE_UP'                  => 'Deslizar para cima',
	'AD_SLIDE_UP_DESC'             => 'Mostrado em cada página depois de o utilizador fazer scroll abaixo do conteúdo principal. Desliza a partir do fundo.',
	'AD_SCRIPTS'                   => 'Scripts',
	'AD_SCRIPTS_DESC'              => 'Este local é para código JavaScript especial como AdSense Auto ads, códigos de tracking, etc. O código inserido aqui será colocado na tag HEAD da página e não serve para exibir o anúncio, mas apenas para scripts auxiliares.',
]);
