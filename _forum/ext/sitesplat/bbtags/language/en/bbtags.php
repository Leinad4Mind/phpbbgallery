<?php
/**
*
* BBtags
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
	'BBTAGS'	            		=> 'Tags',
	'BBTAGS_AUTO_SUGGEST'			=> 'Auto Suggest',
	'BBTAGS_TAG_SPEC'	    		=> 'characters: [a-z 0-9 + # - .] Delimit tags by semicolon, comma or press enter',
	
	'BBTAGS_ENTER_TAGS_PLACEHOLDER'	=> 'Enter tags...',
	'TOPICTIME'		        		=> 'Topic active time',
));
