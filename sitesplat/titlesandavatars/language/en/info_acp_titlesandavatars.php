<?php
/**
*
* BBAvatars
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
	'TAT'						=> 'BBAvatars',
	'TAT_SHOW_AVATARS'			=> 'Show Avatars in Forumlist',
	'TAT_SHOW_AVATARS_EXPLAIN'	=> 'Display Avatar from last-, first- or both poster',
	'TAT_SHOW_AVATARS_ML'		=> 'Show Avatars in Memberlist',
	'TAT_SHOW_AVATARS_PP'		=> 'Show Contributors Avatars in Topic',
	'TAT_SHOW_AVATARS_OL'		=> 'Show Avatars in Online-list',

	'TAT_BOTH'					=> 'Show both Avatars',
	'TAT_FIRST'					=> 'Show only first poster Avatar',
	'TAT_LAST'					=> 'Show only last poster Avatar',
	
	'TAT_AVATAR_FIRST'			=> 'First poster:',
	'TAT_AVATAR_LAST'			=> 'Last poster:',
	
	'TAT_NOTICE'				=> '<div style="width:80%%;margin:20px auto;"><p><strong>The setting for this extension are in %1$s » %2$s » %3$s.</strong></p></div>',

));
