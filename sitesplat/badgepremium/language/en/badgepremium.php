<?php
/**
*
* BBAwards premium rule PAK.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
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
	'BADGE_TYPE_BOOKMARKED'			=> 'Bookmarked',
	'BADGE_TYPE_CROSS_BADGE'		=> 'Cross Badge',
	'BADGE_TYPE_POLLS'				=> 'Polls',
	'BADGE_TYPE_REPORTS'			=> 'Reports',
	'BADGE_TYPE_SUBSCRIBED'			=> 'Subscribed',
	'BADGE_TYPE_TOPICS'				=> 'Topics',

	'BADGEAUTO_TYPE_BOOKMARKED'		=> 'Badge Award Bookmarked',
	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Badge Award Cross Badge',
	'BADGEAUTO_TYPE_POLLS'			=> 'Badge Award Polls',
	'BADGEAUTO_TYPE_REPORTS'		=> 'Badge Award Reports',
	'BADGEAUTO_TYPE_SUBSCRIBED'		=> 'Badge Award Subscribed',
	'BADGEAUTO_TYPE_TOPICS'			=> 'Badge Award Topics',

	'BOOKMARKED_EXPLAIN'			=> 'Award badges to topicstarters whose topic is bookmarked by members',
	'CROSS_BADGE_EXPLAIN'			=> 'Award badges to specific rules',
	'POLLS_EXPLAIN'					=> 'Award badges to posters who made a poll',
	'REPORTS_EXPLAIN'				=> 'Award badges to reporters',
	'SUBSCRIBED_EXPLAIN'			=> 'Award badges to topicstarters who`s topics are subscribed by members',
	'TOPICS_EXPLAIN'				=> 'Award badges to topicstarters',

	'ACP_BADGE_RULESLIST'			=> 'Rules-list',
	'ACP_BADGE_RULESLIST_EXPLAIN'	=> 'Select multiple rules by holding CTRL and clicking.',
	'BADGE_PREMIUM_NOTICE'			=> '<div style="width:80%%;margin:20px auto;"><p>The Setting for this extension are in %1$s » %2$s » %3$s.</p></div>',
));
