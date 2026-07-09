<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
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
	'BBADBLOCK_MSG'		   => 'You are using an adblocker, we respect that but it\'s not cool as we need the ads to be running :-/',
	'BBADBLOCK_MSG_POST'   => 'This post is hidden because you are using an adblock. We get it, but we need the ads running. Please whitelist our site.',
	'BBADBLOCK_TOGO'	   => 'pages to go'
));
