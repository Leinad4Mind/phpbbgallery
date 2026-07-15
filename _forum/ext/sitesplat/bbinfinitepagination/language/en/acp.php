<?php
/**
*
* @package BBinfinitepagination
* @copyright (c) 2019 SiteSplat All rights reserved
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
	'BBINFINITEPAGINATION'		=> 'BBinfinitepagination',
	'BBINFINITEPAGINATION_FX'	=> 'BBinfinitepagination effect',
	'BBINFINITEPAGINATION_VIEWTOPIC'	=> 'Allow BBinfinitepagination to load more posts in viewtopic',
	'BBINFINITEPAGINATION_MEMBERLIST'	=> 'Allow BBinfinitepagination to load more members in memberlist',
	'BBINFINITEPAGINATION_VIEWONLINE'	=> 'Allow BBinfinitepagination to load more users in viewonline',
	'BBINFINITEPAGINATION_SEARCH'		=> 'Allow BBinfinitepagination to load more posts/topics in search results',
	'BBINFINITEPAGINATION_VIEWFORUM'	=> 'Allow BBinfinitepagination to load more topics in viewforum',
));
