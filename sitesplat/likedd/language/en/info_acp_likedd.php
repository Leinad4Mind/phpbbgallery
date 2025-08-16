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
    'LIKEBB_NOTICE'				    => '<div style="width:80%;margin:20px auto;"><p>The Setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Make sure to check the Group permission and adjust it as needed. By default the Registered user group can like and can dislike posts.</p></div>',
	'ACP_LIKEDD_TITLE'				=> 'phpBB Ajax likeBB',
	'LIKEDD_DISLIKE_OFF'			=> 'Disable Dislike function',
    'LIKEDD_DISLIKE_OFF_EXPLAIN'	=> 'Turns on/off the entire dislike system. <br />NOTE: Granular permission is possible with the "Group Permission" as you can set the like /dislike permission for each Groups.<br /> ACP > Users and Groups > Group Permission "select Group" then choose "Can like posts" and "Can dislike posts".',
	'LIKEDD_LIKE_STYLE'				=> 'Button colors for like / dislike',
    'LIKEDD_LIKE_STYLE_EXPLAIN'		=> 'Select a CSS class to be applied to the like / dislike buttons<br /> NOTE: The class <strong>btn-l-cst</strong> allows you to have your own custom css defined.<br /> Make sure to add it in your custom.css stylesheet',
	'LIKEDD_LIKE_ICON'				=> 'Icon picker for like / dislike',
	'LIKEDD_LIKE_ICON_EXPLAIN'		=> 'Choose the icon for your like / dislike buttons',
	'LIKEDD_LIKE_LIST'				=> 'Likers List in topic',
    'LIKEDD_LIKE_LIST_EXPLAIN'		=> 'Turns on/off user likers list in viewtopic',
	'LIKEDD_MAX_DISLIKES'			=> 'Max. dislikes',
	'LIKEDD_MAX_DISLIKES_EXPLAIN'	=> 'Max. dislikes until message will be hidden from view. 0 switches the function off',
	'LIKEDD_LIKE_GLOBAL'			=> 'Global Announcements like / dislike ',
	'LIKEDD_LIKE_GLOBAL_EXPLAIN'	=> 'Turns on/off like / dislike in Global Announcements',
	'LIKEDD_LIKE_LOCKED'			=> 'Locked topics like / dislike ',
	'LIKEDD_LIKE_LOCKED_EXPLAIN'	=> 'Turns on/off like / dislike in Locked topics',
	'ACL_U_LIKEDD'					=> 'Can use LikeBB UCP module and LikeBB Top 10 page',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
));
