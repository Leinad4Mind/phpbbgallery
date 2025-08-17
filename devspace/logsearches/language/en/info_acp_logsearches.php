<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

/// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'NO_LOG_ENTRIES_SELECTED'	=> 'No log entries selected',

	'POSTS_SEARCH'				=> 'Post search',

	'SEARCH_AUTHOR'				=> 'Author',
	'SEARCH_DATA'				=> 'Searched terms',
	'SEARCH_FAIL'				=> 'Fail',
	'SEARCH_FORA'				=> 'Searched fora',
	'SEARCH_LOG'				=> 'Search log',
	'SEARCH_LOG_CLEAR'			=> '<strong>Search log file cleared</strong>',
	'SEARCH_LOG_EXPLAIN'		=> 'This lists the actions carried out by searches. This log provides you with information you are able to use for solving specific search problems. You can sort by username, date, IP or keyword. If you have appropriate permissions you can also clear individual log entries.',
	'SEARCH_LOG_LOG'			=> '<strong>Search log options updated</strong>',
	'SEARCH_LOG_MANAGE'			=> 'Manage search log',
	'SEARCH_LOG_PRUNE_LOG'		=> '<strong>Search log file pruned</strong>',
	'SEARCH_LOG_OPTIONS'		=> 'Search log options',
	'SEARCH_STATUS'				=> 'Status',
	'SEARCH_SUCCESS'			=> 'Success',
	'SEARCH_TITLE'				=> 'Search type',
	'SORT_KEYWORDS'				=> 'Keywords',

	'SEARCH_TYPE'	=> array(
		'posts'		=> 'Posts',
		'topics'	=> 'Topics',
	),
));
