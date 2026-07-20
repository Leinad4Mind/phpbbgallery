<?php

/**
 * @package BBajaxnews for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
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
	'BBAJAXNEWS_TITLE_MEMBER_DONATION'   => 'Doação de %s',
	'BBAJAXNEWS_TITLE_MEMBER_MEMBERSHIP' => '%s agora é',
	'BBAJAXNEWS_TITLE_MEMBER_VOTE'       => '%s votou na melhor resposta',
	'BBAJAXNEWS_TITLE_FRIEND_LOGGED_IN'  => '%s conectou-se',
	'BBAJAXNEWS_TITLE_NEW_ANNOUNCEMENT'  => 'Novo anúncio!',
	'BBAJAXNEWS_TITLE_NEW_STICKY'        => 'Novo tópico fixo!',
	'BBAJAXNEWS_TITLE_NEW_TOPIC'         => 'Novo tópico de %s',
	'BBAJAXNEWS_TITLE_USER_JOINED_BOARD' => 'Novo utilizador juntou-se a nós',
	'BBAJAXNEWS_TITLE_USER_JOINED_GROUP' => 'Juntou-se recentemente',

	'BBAJAXNEWS_TITLE_NEW_POSTS_TODAY'  => 'Notícia diária',
	'BBAJAXNEWS_TITLE_RANDOM_POLL'      => 'A sua opinião é importante',
	'BBAJAXNEWS_TITLE_USERS_ONLINE_24H' => 'Estatísticas Ativas',
	'BBAJAXNEWS_TITLE_USERS_ONLINE'     => 'Estatísticas Online',

	'BBAJAXNEWS_MEMBER_DONATION'   => '%2$s%1$s doou o valor de <strong>%3$s</strong> para o nosso fórum. Obrigado!',
	'BBAJAXNEWS_MEMBER_MEMBERSHIP' => '%2$s%1$s tem agora uma nova associação <strong>%3$s</strong>.',
	'BBAJAXNEWS_MEMBER_VOTE'       => 'Obrigado %2$s%1$s por ajudar a nossa comunidade',
	'BBAJAXNEWS_FRIEND_LOGGED_IN'  => 'Diga olá a %2$s%1$s :-)',
	'BBAJAXNEWS_NEW_ANNOUNCEMENT'  => 'Acabou de ser colocado. Verifique em %2$s%1$s',
	'BBAJAXNEWS_NEW_STICKY'        => 'Tópico fixo! Leia %2$s%1$s',
	'BBAJAXNEWS_NEW_TOPIC'         => 'Verifique-o! Leia %2$s%1$s',
	'BBAJAXNEWS_USER_JOINED_BOARD' => 'Dê as boas-vindas a %2$s%1$s!',
	'BBAJAXNEWS_USER_JOINED_GROUP' => '%2$s%1$s juntou-se a: %3$s',

	'BBAJAXNEWS_NEW_POSTS_TODAY'  => 'Os nossos utilizadores escreveram <strong>%1$s</strong> novas publicações hoje.',
	'BBAJAXNEWS_RANDOM_POLL'      => 'Vote em %2$s%1$s',
	'BBAJAXNEWS_USERS_ONLINE_24H' => 'Foram encontrados %1$s utilizadores conectados nas últimas 24h',
	'BBAJAXNEWS_USERS_ONLINE'     => 'Há um total de %1$s utilizadores atualmente conectados',

	'MINUTES' => 'Minutos',
]);
