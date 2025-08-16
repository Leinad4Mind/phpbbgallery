<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 SiteSplat All rights reserved
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
	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Watched keyword found in a topic subject',
	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A keyword "%s" is part of a new topic subject.',
	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Watched keyword found in a post content',
	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A keyword "%s" is part of a new post content.',
));
