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
	
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBAVATARS_NOTICE'	            => '<div class="phpinfo"><p>The setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s.</strong></p></div>',

));
