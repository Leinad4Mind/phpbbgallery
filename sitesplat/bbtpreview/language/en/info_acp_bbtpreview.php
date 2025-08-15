<?php
/**
*
* BBtpreview
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
	'BBTPREVIEW_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p>There are no specific settings for this extension. Mouse hover the topic list to discover the magnify glass button for the topic preview. Enjoy!</p></div>',
));
