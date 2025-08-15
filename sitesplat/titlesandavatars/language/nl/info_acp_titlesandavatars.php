<?php
/**
*
* Titles and Avatars
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
	'TAT'						=> 'Titel en avatars',
	'TAT_SHOW_AVATARS'			=> 'Toon avatars',
	'TAT_SHOW_AVATARS_EXPLAIN'	=> 'Toont avatars van laatste-, eerste of beide posters',

	'TAT_BOTH'					=> 'Toon beide avatars',
	'TAT_FIRST'					=> 'Toon alleen eerste poster',
	'TAT_LAST'					=> 'Toon alleen laatste poster',

	'TAT_AVATAR_FIRST'			=> 'Eerste poster:',
	'TAT_AVATAR_LAST'			=> 'Laatste poster:',
	
	'TAT_NOTICE'				=> '<div style="width:80%%;margin:20px auto;"><p>Configuratie instellingen van deze extensie vindt je in %1$s » %2$s » %3$s.</p></div>',

));
