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
	'BBTAGS_SEARCH_TAGS'             => 'Search by tags',
	'BBTAGS_SEARCH_OPERATOR'         => 'Tag matching mode',
	'BBTAGS_MATCH_ALL'               => 'Match all tags',
	'BBTAGS_MATCH_ANY'               => 'Match any tag',
	'BBTAGS_FILTERING_BY'            => 'Filtering by',
	'BBTAGS_ADD_FILTER'              => 'Add this tag to the filter',
	'BBTAGS_REMOVE_FILTER'           => 'Remove this tag from the filter',
	'BBTAGS_CLEAR_FILTERS'           => 'Clear filters',
	'BBTAGS_PENDING_NOTICE'          => 'New tags shown here are awaiting approval and are not public yet.',
	'TOPICTIME'		        		=> 'Topic active time',
));
