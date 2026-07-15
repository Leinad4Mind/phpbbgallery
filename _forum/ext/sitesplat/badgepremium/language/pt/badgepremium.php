<?php
/**
*
* BBAwards premium rule PAK.
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
**/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'BADGE_TYPE_BOOKMARKED'			=> 'Favoritos',
	'BADGE_TYPE_BBPOINTS'			=> 'Pontos',
	'BADGE_TYPE_CROSS_BADGE'		=> 'Conjuntos',
	'BADGE_TYPE_POLLS'				=> 'Votações',
	'BADGE_TYPE_REPORTS'			=> 'Reportar',
	'BADGE_TYPE_SUBSCRIBED'			=> 'Subscritos',
	'BADGE_TYPE_TOPICS'				=> 'Tópicos',

	'BADGEAUTO_TYPE_BOOKMARKED'		=> 'Medalha Favoritos',
	'BADGEAUTO_TYPE_BBPOINTS'		=> 'Medalha Pontos',
	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Medalha Conjuntos',
	'BADGEAUTO_TYPE_POLLS'			=> 'Medalha Votações',
	'BADGEAUTO_TYPE_REPORTS'		=> 'Medalha Reportar',
	'BADGEAUTO_TYPE_SUBSCRIBED'		=> 'Medalha Subscritos',
	'BADGEAUTO_TYPE_TOPICS'			=> 'Medalha Tópicos',

	'BOOKMARKED_EXPLAIN'			=> 'Award badges to topic-starters whose topic is bookmarked by members',
	'BBPOINTS_EXPLAIN'				=> 'Award badges to users with BBpoints',
	'CROSS_BADGE_EXPLAIN'			=> 'Award badges to specific rules',
	'POLLS_EXPLAIN'					=> 'Award badges to posters who made a poll',
	'REPORTS_EXPLAIN'				=> 'Award badges to reporters',
	'SUBSCRIBED_EXPLAIN'			=> 'Award badges to topic-starters who`s topics are subscribed by members',
	'TOPICS_EXPLAIN'				=> 'Award badges to topic-starters',

	'ACP_BADGE_RULESLIST'			=> 'Rules-list',
	'ACP_BADGE_RULESLIST_EXPLAIN'	=> 'Select multiple rules by holding CTRL and clicking.',
	'BADGE_PREMIUM_NOTICE'			=> '<div><p>The Setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
));
