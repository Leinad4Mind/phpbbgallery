<?php
/**
*
* phpBB Ajax likeBB.
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
	'ACP_LIKEDD_TITLE'				=> 'phpBB Ajax likeBB',
	'LIKEDD_DISLIKE_OFF'			=> 'Disable Dislike function',
    'LIKEDD_DISLIKE_OFF_EXPLAIN'	=> 'Turns on/off the dislike button in posts',
	'LIKEDD_LIKE_STYLE'				=> 'Style your like / dislike button',
    'LIKEDD_LIKE_STYLE_EXPLAIN'		=> 'Preview of your like / dislike button<br /> NOTE: The class <strong>btn-l-cst</strong> allows you to have your own custom css defined. Make sure to add it in your custom.css stylesheet',
	'LIKEDD_LIKE_ICON'				=> 'Set your like / dislike icon',
	'LIKEDD_LIKE_LIST'				=> 'Enable Likers List',
    'LIKEDD_LIKE_LIST_EXPLAIN'		=> 'Turns on/off likers list in viewtopic',
	'LIKEDD_MAX_DISLIKES'			=> 'Max. dislikes',
	'LIKEDD_MAX_DISLIKES_EXPLAIN'	=> 'Max. dislikes until message will be hidden from view. 0 switches the function off',
	'LIKEDD_LIKE_GLOBAL'			=> 'Like / Dislike Global Announcements',
	'LIKEDD_LIKE_GLOBAL_EXPLAIN'	=> 'Turns on/off like / dislike in Global Announcements',
	'LIKEDD_LIKE_LOCKED'			=> 'Like / Dislike Locked topics',
	'LIKEDD_LIKE_LOCKED_EXPLAIN'	=> 'Turns on/off like / dislike in Locked topics',
));
