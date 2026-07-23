<?php

/**
 * phpBB Ajax likeBB.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
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
	'LIKE_MODE_ERROR'          => 'O modo não existe',
	'LIKE_POST_ERROR'          => 'A mensagem não existe',
	'LIKE_POST_NO_AUTH'        => 'Não tens autorização para gostar/desgostar desta mensagem.',
	'LIKE_OWN_POST_ERROR'      => 'Não podes gostar/desgostar da tua própria mensagem.',
	'LIKE_DISLIKE_OFF_INFO'    => 'Não sejas maroto. A opção de desgostar está desactivada',
	'LIKE_LIKE_TIME_ERROR'     => 'Não podes gostar/desgostar de uma mensagem tão depressa!',
	'LIKE_DISLIKE_REMOVE_INFO' => 'Para remover o teu desgosto, clica no botão de desgostar.',
	'LIKE_LIKE_REMOVE_INFO'    => 'Para remover o teu gosto, clica no botão de gostar.',
	'LIKE_USER_INFO_LIKE'      => 'gosto',
	'LIKE_USER_INFO_DISLIKE'   => 'desgosto',
	'ADDED'                    => 'adicionado',
	'REMOVED'                  => 'removido',
	'INFOMSG'                  => 'Atenção!',
	'FROM_YOUR'                => 'da tua',
	'TO_YOUR'                  => 'à tua',

	'LIKEDD_NOTIFICATION_EVENT_ADDED'  => '<strong>%1$s</strong> %2$s por %3$s em:<br />%4$s',
	'LIKE_USER_INFO_REMOVED'           => 'O teu %s desta mensagem foi removido.',
	'LIKE_USER_INFO_APPRECIATE'        => '%s agradece o teu gosto na mensagem dele!',
	'LIKE_USER_INFO_APPRECIATE_STRONG' => '<div class="ld-ajax"><strong>%s</strong> agradece o teu gosto na mensagem dele!</div>',
	'LIKE_POST_INFO_DISLIKE'           => 'A mensagem de %s recebeu um desgosto.',
	'LIKE_POST_INFO_DISLIKE_STRONG'    => '<div class="ld-ajax">A mensagem de <strong>%s</strong> recebeu um desgosto.</div>',
	'TO_MANY_DISLIKES'                 => 'Este conteúdo recebeu demasiados desgostos. Clica em <a class="label label-warning label-dsk" href="javascript:void(0)" data-toggle="collapse" data-target=".dkd-wrapper-%s">MOSTRAR</a> para veres',

	'LIKES_OTHERS'             => 'Outros',
	'LIKES_LIKE_THIS'          => 'gostam disto',
	'LIKES_LIKERS'             => 'Quem gostou desta mensagem',
	'LIKES_AND'                => 'e',
	'LIKES_LIKED_LAST'         => 'foi o último a gostar!',
	'LIKES_LINK_OTHER_TOOLTIP' => 'Vê quem gostou disto',
	'LIKES_TOP_LIST'           => 'Top 10 Gostos / Desgostos',

	'LIKE_ACTIVITY_UCP_EMPTY' => 'Ainda não há actividade. O que estás à espera? :-)',

	'LIKES_PAGE_TITLE'     => 'Lista principal',
	'LIKES_TABLE_TITLE'    => 'Classificação',
	'LIKES_AUTHOR'         => 'Autor',
	'LIKES_POST_SUBJECT'   => 'Mensagem/Assunto',
	'LIKES_LIKES_DISLIKES' => 'gostos/desgostos',

	'LIKES_SORT_TITLE'   => 'Ordenar por gostos/desgostos',
	'LIKES_SORT_LIKES'   => 'Gostos',
	'LIKES_SORT_DISIKES' => 'Desgostos',

	'LIKES_SORT_DATE'      => 'Ordenar por data',
	'LIKES_SORT_POSTS_AMT' => 'Ordenar por mensagem',

	'NO_LIKES'                     => 'Não foi encontrado nenhum gosto!',
	'NOTIFICATION_TYPE_LIKEDD_ADD' => 'Alguém gosta ou desgosta de uma das tuas mensagens',

	'UCP_LD_GIVEN'          => 'Dados',
	'UCP_LD_RECEIVED'       => 'Recebidos',
	'LIKES_GIVEN'           => 'Gosto Dado',
	'LIKES_RECEIVED'        => 'Gosto Recebido',
	'DISLIKES_GIVEN'        => 'Desgosto Dado',
	'DISLIKES_RECEIVED'     => 'Desgosto Recebido',
	'LIKE_REMOVED'          => 'Gosto removido',
	'DISLIKE_REMOVED'       => 'Desgosto removido',
	'LIKES_LIKE_IT'         => 'Gosto disto',
	'LIKES_LIKE'            => 'Gosto',
	'LIKES_LIKED'           => 'Gostado',
	'LIKES_DISLIKE_IT'      => 'Desgosto disto',
	'LIKES_DISLIKE'         => 'Desgosto',
	'LIKES_DISLIKE_REMOVED' => 'Gosto / Desgosto removido',
	'LIKES_ALL_LIKES'       => 'de todos os gostos',
	'LIKES_ALL_DISLIKES'    => 'de todos os desgostos',

	'AND'        => 'e',
	'OTHERS'     => 'outros',
	'LIKED_THIS' => 'gostaram disto',

	'LIKES_OVERVIEW_FORUM' => 'Vista geral do fórum',
	'LIKES_OVERVIEW_TOPIC' => 'Vista geral do tópico',
	'LIKES_OVERVIEW_POSTS' => 'Vista geral das mensagens',
	'LIKES_OVERVIEW_USER'  => 'Vista geral do utilizador',

	'UCP_LIKEDD_TITLE'   => 'Vista geral de Gostos / Desgostos',
	'UCP_LIKEBB_EXPLAIN' => 'Vista geral de todos os gostos e desgostos que deste ou recebeste'
]);
