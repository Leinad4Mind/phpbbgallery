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
	// special
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBDONATION'        => '%s acabou de fazer um donativo.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBMEMBERSHIP'      => '%s comprou a adesão LV%s.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBVOTE'            => 'A melhor resposta foi marcada em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_FRIEND_LOGGED_IN'  => 'O teu amigo %s acabou de iniciar sessão.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_ANNOUNCEMENT'  => '%s acabou de publicar um novo anúncio "%s" em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_STICKY'        => '%s acabou de fixar o tópico "%s" em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_TOPIC'         => '%s acabou de publicar o novo tópico "%s" em "%s".',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_BOARD' => '%s acabou de se juntar ao fórum.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_GROUP' => '%s acabou de se juntar ao grupo especial %s.',

	// casual
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_POSTS_TODAY' => [
		0 => 'Ainda não foi publicada nenhuma mensagem hoje.',
		1 => 'Foi publicada 1 mensagem até agora hoje.',
		2 => 'Foram publicadas %d mensagens até agora hoje.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE_24H' => [
		0 => 'Não esteve nenhum utilizador online nas últimas %dh.',
		1 => 'Esteve um utilizador online na última %2$dh.',
		2 => 'Estiveram %d utilizadores online nas últimas %dh.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE' => [
		0 => 'Não está ninguém online neste momento.',
		1 => 'Está atualmente 1 utilizador online neste momento.',
		2 => 'Estão atualmente %d utilizadores online neste momento.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL_NONE' => 'Já votaste em todas as votações disponíveis. Boa!',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL'      => 'Há uma votação "%s" à espera da tua resposta.',
]);
