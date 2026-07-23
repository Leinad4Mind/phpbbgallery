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
	// special
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBDONATION'        => '%s acabou de fazer uma doação.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBMEMBERSHIP'      => '%s comprou a assinatura LV%s.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBVOTE'            => 'A melhor resposta foi marcada em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_FRIEND_LOGGED_IN'  => 'Seu amigo %s acabou de fazer login.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_ANNOUNCEMENT'  => '%s acabou de publicar um novo anúncio "%s" em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_STICKY'        => '%s acabou de fixar o tópico "%s" em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_TOPIC'         => '%s acabou de postar o novo tópico "%s" em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_BOARD' => '%s acabou de entrar no fórum.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_GROUP' => '%s acabou de entrar no grupo especial %s.',

	// casual
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_POSTS_TODAY' => [
		0 => 'Ainda não foi postado nenhum post hoje.',
		1 => 'Foi postado 1 post até agora hoje.',
		2 => 'Foram postados %d posts até agora hoje.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE_24H' => [
		0 => 'Nenhum usuário esteve online nas últimas %dh.',
		1 => 'Um usuário esteve online na última %2$dh.',
		2 => '%d usuários estiveram online nas últimas %dh.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE' => [
		0 => 'Não há ninguém online neste momento.',
		1 => 'Há atualmente 1 usuário online neste momento.',
		2 => 'Há atualmente %d usuários online neste momento.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL_NONE' => 'Você já votou em todas as votações disponíveis. Legal!',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL'      => 'Há uma votação "%s" esperando sua resposta.',
]);
