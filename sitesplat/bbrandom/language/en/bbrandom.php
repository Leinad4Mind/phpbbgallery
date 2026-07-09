<?php
/**
*
* @package BBrandom
* @copyright (c) 2016 SiteSplat All rights reserved
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
	'AVATAR_DRIVER_RGRAVATAR_TITLE'		=> 'Random Gravatar',
	'AVATAR_DRIVER_RGRAVATAR_EXPLAIN'	=> 'This option will allow the use of a Random Gravatar',
	'BBRANDOM_SITESPLAT'	            => '<i class="icon fa fa-info-circle"></i> Random Avatars Extension by <a href="http://www.sitesplat.com" title="Professional Web Development"><strong>SiteSplat.com</strong></a> built for <a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="Professional Premium Themes"><strong>SiteSplat\'s Themes</strong></a>',
));
