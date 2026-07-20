<?php

/**
 * phpBB Ajax likeBB.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
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
	'NOTIFICATION_TYPE_SITESPLAT.LIKEDD.NOTIFICATION.TYPE.LIKEDD_ADDED' => 'Somebody liked / disliked your post',

	'LIKE_MODE_ERROR'          => 'Mode does not exist',
	'LIKE_POST_ERROR'          => 'Post does not exist',
	'LIKE_POST_NO_AUTH'        => 'Não tens permissões para gostar/desgostar deste tópico.',
	'LIKE_OWN_POST_ERROR'      => 'Não podes gostar/desgostar do teu próprio tópico.',
	'LIKE_DISLIKE_OFF_INFO'    => 'Não sejas inácio. A opção desgostar encontra-se desativada',
	'LIKE_LIKE_TIME_ERROR'     => 'Não podes gostar - desgostar um tópico assim tão rápido!',
	'LIKE_DISLIKE_REMOVE_INFO' => 'Para remover um desgosto, clica no botão Não Gosto.',
	'LIKE_LIKE_REMOVE_INFO'    => 'Para remover o teu agradecimento, clica no botão agradecer.',
	'LIKE_USER_INFO_LIKE'      => 'Gosto',
	'LIKE_USER_INFO_DISLIKE'   => 'Não gosto',
	'ADDED'                    => 'adicionado',
	'REMOVED'                  => 'removido',
	'INFOMSG'                  => 'Heads up!',

	'LIKEDD_NOTIFICATION_EVENT_ADDED'  => '<strong>%1$s</strong> %2$s por %3$s em:<br />%4$s',
	'LIKE_USER_INFO_REMOVED'           => 'O teu %s desta mensagem foi removido.',
	'LIKE_USER_INFO_APPRECIATE'        => '%s aprecia o facto de agradeceres o tópico!',
	'LIKE_USER_INFO_APPRECIATE_STRONG' => '<div class="ld-ajax"><strong>%s</strong> aprecia o facto de agradeceres o tópico!</div>',
	'LIKE_POST_INFO_DISLIKE'           => 'Mensagem por %s foi desgostada.',
	'LIKE_POST_INFO_DISLIKE_STRONG'    => '<div class="ld-ajax">Mensagem por <strong>%s</strong> foi desgostada.</div>',
	'TO_MANY_DISLIKES'                 => 'This content received too many dislikes. Click <a class="label label-warning label-dsk" href="javascript:void(0)" data-toggle="collapse" data-target=".dkd-wrapper-%s">SHOW</a> to view',

	'LIKES_OTHERS'             => 'Outros',
	'LIKES_LIKE_THIS'          => 'agradeceram',
	'LIKES_LIKERS'             => 'Agradecimentos de',
	'LIKES_AND'                => 'e',
	'LIKES_LIKED_LAST'         => 'último a agradecer!',
	'LIKES_LINK_OTHER_TOOLTIP' => 'Vê quem agradeceu',
	'LIKES_TOP_LIST'           => 'Top 10 Agradecimentos',

	'LIKE_ACTIVITY_UCP_EMPTY' => 'There is no activity yet. What are you waiting for? :-)',

	'LIKES_PAGE_TITLE'     => 'Top list',
	'LIKES_TABLE_TITLE'    => 'Leaderboard',
	'LIKES_AUTHOR'         => 'Autor',
	'LIKES_POST_SUBJECT'   => 'Mensagem/Assunto',
	'LIKES_LIKES_DISLIKES' => 'likes/dislikes',

	'LIKES_SORT_TITLE'   => 'Sort by Likes/dislikes',
	'LIKES_SORT_LIKES'   => 'Agradecimentos',
	'LIKES_SORT_DISIKES' => 'Dislikes',

	'LIKES_SORT_DATE'      => 'Sort by date',
	'LIKES_SORT_POSTS_AMT' => 'Sort by post',

	'NO_LIKES'                     => 'No likes found!',
	'NOTIFICATION_TYPE_LIKEDD_ADD' => 'Someone likes or dislikes any of your posts',

	'UCP_LD_GIVEN'          => 'Oferecidos',
	'UCP_LD_RECEIVED'       => 'Recebidos',
	'LIKES_GIVEN'           => 'Agradecimentos Oferecidos',
	'LIKES_RECEIVED'        => 'Agradecimentos Recebidos',
	'DISLIKES_GIVEN'        => 'Dislike Given',
	'DISLIKES_RECEIVED'     => 'Dislike Received',
	'LIKE_REMOVED'          => 'Agradecimento removido',
	'DISLIKE_REMOVED'       => 'Dislike removed',
	'LIKES_LIKE_IT'         => 'Obrigado por isto!',
	'LIKES_LIKE'            => 'Agradecer',
	'LIKES_LIKED'           => 'Já agradeceu',
	'LIKES_DISLIKE_IT'      => 'I Dislike This',
	'LIKES_DISLIKE'         => 'Dislike',
	'LIKES_DISLIKE_REMOVED' => 'Like / Dislike removed',
	'LIKES_ALL_LIKES'       => 'of all likes',
	'LIKES_ALL_DISLIKES'    => 'of all dislikes',

	'AND'        => 'e',
	'OTHERS'     => 'outros',
	'LIKED_THIS' => 'agradeceram',

	'LIKES_OVERVIEW_FORUM' => 'Forum overview',
	'LIKES_OVERVIEW_TOPIC' => 'Topic overview',
	'LIKES_OVERVIEW_POSTS' => 'Message overview',
	'LIKES_OVERVIEW_USER'  => 'User overview',

	'UCP_LIKEDD_TITLE'   => 'Like / Dislike overview',
	'UCP_LIKEDD_EXPLAIN' => 'Overview of all likes and dislikes you give or received'
]);
