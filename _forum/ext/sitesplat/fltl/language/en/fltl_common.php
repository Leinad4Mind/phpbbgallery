<?php
/**
*
* Fancy Lazy Topics Loader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

if (!defined('IN_PHPBB')) {
	exit;
}
if (empty($lang) || !is_array($lang)) {
	$lang = array();
}

$lang = array_merge($lang, array(
	'FLTL'							=> 'Fancy Lazy Topics loader',
	'FLTL_EXPLAIN'					=> 'Scroll down for more topics',
	'FLTL_BY'					    => '&nbsp;&#45;&nbsp;By&nbsp;',
	'FLTL_LIMIT'					=> 'Posts to display',
	'FLTL_LIMIT_EXPLAIN'			=> 'Set the posts block per each row (4 default)',
	
	'FLTL_TIME'						=> 'Topic Fetch Limit',
	'FLTL_TIME_EXPLAIN'				=> 'Set the amount in days for how far back to fetch topics from the database. 0 disables the limit.',

	'FLTL_TYPE'						=> 'Sort order',
	'FLTL_TYPE_EXPLAIN'				=> 'Display first or last post from recent topics',
	
	'FLTL_EXCLUDED_FORUMS'			=> 'Exclude forums from the Fancy Lazy Topics loader',
	'FLTL_EXCLUDED_FORUMS_EXPLAIN'	=> 'Hold shift or control for selecting more forums',

	'FLTL_READ_MORE'				=> 'READ MORE',
	'FLTL_BACK_TO_START'			=> 'BACK TO START',
	'FLTL_VIEW_MORE_TOPICS'			=> 'VIEW MORE TOPICS'
));
