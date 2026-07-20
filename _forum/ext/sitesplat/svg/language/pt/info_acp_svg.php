<?php

/**
 * @package BBsvg for phpBB.
 * common [English]
 * @copyright (c) 2017 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'FORUM_ICONS'              => 'Ícones do Fórum',
	'BBSVG_NOTICE'             => '<div style="width:auto;margin:20px auto;"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />Também pode adicionar SVGs para os ranks (níveis) de grupos. <strong>ACP &#187; Utilizadores e Grupos &#187; Utilizadores &#187; Gerir ranks</strong>.</p></div>',
	'SS_HELPER_NOTY'           => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'ACP_BBSVG_FORUMS'         => 'Administração do fórum. Selecione o fórum e edite-o para encontrar as configurações de ícones personalizados do fórum',
	'ACP_BBSVG_FORUMS_EXPLAIN' => 'Se pretender remover o círculo cinzento padrão na lista de fóruns/tópicos, pode adicionar o seguinte código ao seu custom.css:',

	'VIEWFORUM_ICON_FOLDER_UNREAD'         => 'Ícone de viewforum com tópicos não lidos',
	'VIEWFORUM_ICON_FOLDER_UNREAD_EXPLAIN' => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewforum normal com tópicos não lidos para associar a este fórum.',
	'VIEWFORUM_ICON_FOLDER_READ'           => 'Ícone de viewforum lido',
	'VIEWFORUM_ICON_FOLDER_READ_EXPLAIN'   => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewforum normal lido para associar a este fórum.',
	'VIEWFORUM_ICON_LOCK'                  => 'Ícone de viewforum trancado',
	'VIEWFORUM_ICON_LOCK_EXPLAIN'          => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewforum trancado para associar a este fórum.',
	'VIEWFORUM_ICON_LINK'                  => 'Ícone de link de viewforum',
	'VIEWFORUM_ICON_LINK_EXPLAIN'          => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de link de viewforum para associar a este fórum.',

	'VIEWTOPIC_ICON_LOCK'                    => 'Ícone de viewtopic trancado',
	'VIEWTOPIC_ICON_LOCK_EXPLAIN'            => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic trancado para associar a este fórum.',
	'VIEWTOPIC_ICON_GLOBAL_UNREAD'           => 'Ícone de viewtopic de anúncio global não lido',
	'VIEWTOPIC_ICON_GLOBAL_UNREAD_EXPLAIN'   => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic de anúncio global não lido para associar a este fórum.',
	'VIEWTOPIC_ICON_GLOBAL_READ'             => 'Ícone de viewtopic de anúncio global lido',
	'VIEWTOPIC_ICON_GLOBAL_READ_EXPLAIN'     => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic de anúncio global lido para associar a este fórum.',
	'VIEWTOPIC_ICON_ANNOUNCE_UNREAD'         => 'Ícone de viewtopic de anúncio não lido',
	'VIEWTOPIC_ICON_ANNOUNCE_UNREAD_EXPLAIN' => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic de anúncio não lido para associar a este fórum.',
	'VIEWTOPIC_ICON_ANNOUNCE_READ'           => 'Ícone de viewtopic de anúncio lido',
	'VIEWTOPIC_ICON_ANNOUNCE_READ_EXPLAIN'   => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic de anúncio lido para associar a este fórum.',
	'VIEWTOPIC_ICON_STICKY_UNREAD'           => 'Ícone de viewtopic inamovível (sticky) não lido',
	'VIEWTOPIC_ICON_STICKY_UNREAD_EXPLAIN'   => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic inamovível (sticky) não lido para associar a este fórum.',
	'VIEWTOPIC_ICON_STICKY_READ'             => 'Ícone de viewtopic inamovível (sticky) lido',
	'VIEWTOPIC_ICON_STICKY_READ_EXPLAIN'     => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic inamovível (sticky) lido para associar a este fórum.',
	'VIEWTOPIC_ICON_POLL_UNREAD'             => 'Ícone de viewtopic de votação não lido',
	'VIEWTOPIC_ICON_POLL_UNREAD_EXPLAIN'     => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic de votação não lido para associar a este fórum.',
	'VIEWTOPIC_ICON_POLL_READ'               => 'Ícone de viewtopic de votação lido',
	'VIEWTOPIC_ICON_POLL_READ_EXPLAIN'       => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic de votação lido para associar a este fórum.',
	'VIEWTOPIC_ICON_MOVED_UNREAD'            => 'Ícone de viewtopic movido não lido',
	'VIEWTOPIC_ICON_MOVED_UNREAD_EXPLAIN'    => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic movido não lido para associar a este fórum.',
	'VIEWTOPIC_ICON_MOVED_READ'              => 'Ícone de viewtopic movido lido',
	'VIEWTOPIC_ICON_MOVED_READ_EXPLAIN'      => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic movido lido para associar a este fórum.',
	'VIEWTOPIC_ICON_NORMAL_UNREAD'           => 'Ícone de viewtopic não lido',
	'VIEWTOPIC_ICON_NORMAL_UNREAD_EXPLAIN'   => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic normal não lido para associar a este fórum.',
	'VIEWTOPIC_ICON_NORMAL_READ'             => 'Ícone de viewtopic lido',
	'VIEWTOPIC_ICON_NORMAL_READ_EXPLAIN'     => 'Localização, relativa ao diretório raiz do phpBB, de um ícone de viewtopic normal lido para associar a este fórum.',
]);
