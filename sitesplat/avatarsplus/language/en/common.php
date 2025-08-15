<?php
/**
* @package BBavatar+
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
	'ALLOW_MATERIAL'					=> 'Enable Material avatars',
	'AVATAR_DRIVER_MATERIAL_TITLE'		=> 'Material avatar',
	'AVATAR_DRIVER_MATERIAL_EXPLAIN'	=> 'Creates a Gmail-like avatar with your username.',
	'MATERIAL_SHAPE'					=> 'Avatar shape',
	'MATERIAL_RANDOM'					=> 'Random',
	'MATERIAL_CIRCLE'					=> 'Circle',
	'MATERIAL_COLUMN'					=> 'Column',
	'MATERIAL_DIAMOND'					=> 'Diamond',
	'MATERIAL_RECTANGLE'				=> 'Rectangle',
	'MATERIAL_RHOMB'					=> 'Rhomb',

	'ALLOW_GENERATOR'					=> 'Enable Avatar Generator',
	'AVATAR_DRIVER_GENERATOR_TITLE'		=> 'Avatar Generator',
	'AVATAR_DRIVER_GENERATOR_EXPLAIN'	=> 'Create your own avatar.',

	'AVATARSPLUS_SHARE_TITLE'	=> 'Hey its Meeeee!',
	'AVATARSPLUS_SHARE_DESC'	=> 'I just created this super cool avatar with an awesome phpBB plugin developed by SiteSplat! Check it out guys! https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat',
	'AVATARSPLUS_SHARE_CREDIT'	=> 'Created with "BBavatar+" from sitesplat.com',
));
