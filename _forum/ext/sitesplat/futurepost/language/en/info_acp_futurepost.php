<?php
/**
*
* BBpostdated
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
	'LOG_FUTURE_POST_APROVED'	=> '<strong>Future post approved</strong><br />&#187; %s',
	'FUTUREPOSTS_NOTICE'	    => '<div style="width:80%;margin:20px auto;"><p>The settings for this extension (date picker) can be found in posting editor.<br />Don\'t forget to check/adjust the permissions if need be. ACP &#187; Permissions &#187; Permission roles &#187; Moderator roles &#187; Full Moderator (green cog , edit) &#187; Misc (tab): Can manage Future Posts</p></div>',
	'SS_HELPER_NOTY'		    => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',

));
