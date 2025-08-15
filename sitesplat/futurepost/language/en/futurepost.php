<?php
/**
*
* Future Posts
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
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
	'FUTURE_DATE'		=> 'Future date'
));
