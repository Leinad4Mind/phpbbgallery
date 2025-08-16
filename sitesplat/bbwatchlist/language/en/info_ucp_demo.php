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
	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Manage keywords',

	'KEYWORD'					=> 'Keyword',
	'SEARCH_TYPE'				=> 'Search type',
	'ACTIONS'					=> 'Actions',
	'NO_KEYWORDS'				=> 'You don\'t have any keywords defined. Add one below!',
	'ADD_NEW_KEYWORD'			=> 'Add a keyword',
	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Match in topic subjects',
	'SEARCH_TYPE_POST_CONTENT'	=> 'Match in posts content',

	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 255 characters',
	'KEYWORD_EXISTS'	=> 'You already have such keyword defined.',
	'KEYWORD_ADDED'		=> 'Keyword has been added',
	'KEYWORD_DELETED'	=> 'Keyword has been deleted',

	// notifications
	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'BBwatchlist',
	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Someone uses a keyword you watch in the topic subject',
	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Someone uses a keyword you watch in the post content',
));
