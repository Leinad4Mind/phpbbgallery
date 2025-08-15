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
));
