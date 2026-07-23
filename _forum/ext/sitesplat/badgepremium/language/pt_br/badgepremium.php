<?php

/**
 * BBAwards premium rule PAK.
 * @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
 * @license SiteSplat 2015 all rights reserved
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
	'BADGE_TYPE_BOOKMARKED'  => 'Favoritos',
	'BADGE_TYPE_BBPOINTS'    => 'Pontos',
	'BADGE_TYPE_CROSS_BADGE' => 'Conjuntos',
	'BADGE_TYPE_POLLS'       => 'Votações',
	'BADGE_TYPE_REPORTS'     => 'Reportar',
	'BADGE_TYPE_SUBSCRIBED'  => 'Subscritos',
	'BADGE_TYPE_TOPICS'      => 'Tópicos',

	'BADGEAUTO_TYPE_BOOKMARKED'  => 'Medalha Favoritos',
	'BADGEAUTO_TYPE_BBPOINTS'    => 'Medalha Pontos',
	'BADGEAUTO_TYPE_CROSS_BADGE' => 'Medalha Conjuntos',
	'BADGEAUTO_TYPE_POLLS'       => 'Medalha Votações',
	'BADGEAUTO_TYPE_REPORTS'     => 'Medalha Reportar',
	'BADGEAUTO_TYPE_SUBSCRIBED'  => 'Medalha Subscritos',
	'BADGEAUTO_TYPE_TOPICS'      => 'Medalha Tópicos',

	'BOOKMARKED_EXPLAIN'  => 'Atribui medalhas aos criadores de tópicos cujo tópico foi marcado como favorito pelos membros',
	'BBPOINTS_EXPLAIN'    => 'Atribui medalhas aos usuários com Pontos BB',
	'CROSS_BADGE_EXPLAIN' => 'Atribui medalhas a regras específicas',
	'POLLS_EXPLAIN'       => 'Atribui medalhas aos autores de posts que criaram uma votação',
	'REPORTS_EXPLAIN'     => 'Atribui medalhas aos denunciantes',
	'SUBSCRIBED_EXPLAIN'  => 'Atribui medalhas aos criadores de tópicos cujos tópicos estão inscritos por membros',
	'TOPICS_EXPLAIN'      => 'Atribui medalhas aos criadores de tópicos',

	'ACP_BADGE_RULESLIST'         => 'Lista de regras',
	'ACP_BADGE_RULESLIST_EXPLAIN' => 'Selecione várias regras mantendo pressionada a tecla CTRL e clicando.',
	'BADGE_PREMIUM_NOTICE'        => '<div><p>As configurações desta extensão encontram-se em <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
]);
