<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A keyword "%s" is a part of a new topic subject.',
	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Watched keyword found in the post content',
	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A keyword "%s" is a part of a new post content.',
));
