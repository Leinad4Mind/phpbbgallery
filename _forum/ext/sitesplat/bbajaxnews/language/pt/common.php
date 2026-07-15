<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	// special
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBDONATION'			=> '%s acabou de efetuar um donativo.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBMEMBERSHIP'		=> '%s comprou o plano Gold%s.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBVOTE'				=> 'Foi marcada uma melhor resposta em “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_FRIEND_LOGGED_IN'	=> 'O seu amigo %s acabou de entrar.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_ANNOUNCEMENT'	=> '%s acabou de publicar um novo anúncio “%s” em “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_STICKY'			=> '%s tornou o tópico “%s” fixo em “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_TOPIC'			=> '%s criou um novo tópico “%s” em “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_BOARD'	=> '%s acabou de se registar na comunidade.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_GROUP'	=> '%s acaba de ser promovido para %s.',

	// casual
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_POSTS_TODAY'	=> [
		0	=> 'Nenhuma mensagem foi enviada no dia de hoje, estás a espera de quê para quebrar o gelo?',
		1	=> 'Finalmente foi enviada 1 mensagem no dia de hoje :P.',
		2	=> 'Já foram enviadas %d mensagens no dia de hoje.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE_24H'	=> [
		0	=> 'Nenhum utilizador esteve online nas últimas %dh.',
		1	=> 'Tivemos um utilizador online nas últimas %2$dh.',
		2	=> 'Tivemos %d utilizadores online nas últimas %dh.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE'	=> [
		0	=> 'Ninguém está online de momento.',
		1	=> 'Apenas 1 utilizador se encontra online de momento.',
		2	=> 'Neste momento, temos %d utilizadores online.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL_NONE'	=> 'Uau, parabéns! Participaste em todas as votações existentes!',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL'		=> 'Existe uma votação à espera  dos teus preciosos votos: “%s”.',
));