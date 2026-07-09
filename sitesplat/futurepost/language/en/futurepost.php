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
	'FUTURE_DATE'		=> 'Future date',
	'FUTURE_POST_ADDED'	=> 'The topic was successfully posted and will appear in the future.',
	'TOPIC_PENDING'		=> 'This topic is pending for future date posting.',
	'LOG_FUTURE_POST_APROVED'		=> 'Future post was successfully published',
));
