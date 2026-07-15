<?php
/**
*
* BBAwards AutoGroup Addon.
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
	'BADGEAUTO_TYPE_AVATAR'			=> 'Badge Award Avatar',
	'BADGEAUTO_TYPE_BADGES'			=> 'Badge Award Badges',
	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Badge Award Cross Badges',
	'BADGEAUTO_TYPE_CUSTOM'			=> 'Badge Award Custom',
	'BADGEAUTO_TYPE_DONATIONS'		=> 'Badge Award Donations',
	'BADGEAUTO_TYPE_LIKEDD'			=> 'Badge Award LikeBB',
	'BADGEAUTO_TYPE_PROFILEWALL'	=> 'Badge Award Profilewall',
	'BADGEAUTO_TYPE_SIGNATURE'		=> 'Badge Award Signature',
	'BADGEAUTO_TYPE_TOPICS'			=> 'Badge Award Topics',
	'BADGEAUTO_TYPE_ZEBRA_FOES'		=> 'Badge Award Foes',
	'BADGEAUTO_TYPE_ZEBRA_FRIENDS'	=> 'Badge Award Friends',

	'BADGE_AUTOGROUPS_NOTICE'		=> '<div class="phpinfo"><p>The Setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.<br />Please note, Badge Rules Types are added together! Extensions like LikeBB, Donation etc won\'t work if they are not installed.</p></div>'
));
