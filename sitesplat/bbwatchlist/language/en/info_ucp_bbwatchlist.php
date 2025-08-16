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
	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Manage keywords',

	'KEYWORD'					=> 'Keyword',
	'SEARCH_TYPE'				=> 'Search type',
	'ACTIONS'					=> 'Actions',
	'KEYWORDS'					=> 'Keywords',
	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'			=> 'You can add keywords to track and be notified about when they are used in posts or subjects',
	'NO_UCP_KEYWORDS'			=> 'You don\'t have any keywords defined. Feel free to add some!',
	'ADD_NEW_KEYWORD'			=> 'Add a keyword',
	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Match in topic subjects',
	'SEARCH_TYPE_POST_CONTENT'	=> 'Match in posts content',

	'KEYWORD_EMPTY'		=> 'Oops! You didn\'t enter a keyword.',
	'KEYWORD_PATTERN'	=> '3 to 50 characters',
	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 255 characters',
	'KEYWORD_EXISTS'	=> 'You already have such keyword defined.',
	'KEYWORD_ADDED'		=> 'Keyword has been added',
	'KEYWORD_DELETED'	=> 'Keyword has been deleted',

	// notifications
	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'BBwatchlist',
	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Someone uses a keyword you watch in the topic subject',
	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Someone uses a keyword you watch in the post content',
));
