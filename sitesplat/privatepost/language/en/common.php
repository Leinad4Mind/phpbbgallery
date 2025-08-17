<?php
/**
*
* Private Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
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

$lang = array_merge($lang, array(
	'PRIVATE_POST'						=> 'Private post',
	'PRIVATE_POST_EXPLAIN'				=> 'Private Posts can ONLY be read by the user with the appropriate permissions. Generally the Admin or the Global Moderators.',
	'PRIVATE_BY'						=> 'Private post by',
	'PRIVATE_POST_NO_CONTENT'			=> 'The content of this post has been marked as private',
	'NO_QUOTE_PRIVATE_POST'				=> 'You cannot quote private posts.',
	'NO_MANIPULATION_PRIVATE_POST'		=> 'You cannot manipulate private posts.',
	'NO_QUICKMOD_WITH_PRIVATE_POST'		=> 'You cannot use quick-mod tools on topics with private posts.',
	'NO_MCP_TOPIC_WITH_PRIVATE_POST'	=> 'You cannot moderate topics with private posts.',
	'NO_MCP_WARN_PRIVATE_POST'			=> 'You cannot warn user for private post.',
	'NO_MCP_POST_DETAILS_PRIVATE_POST'	=> 'You cannot see details of other\'s private posts.',
	'NO_MCP_REPORT_PRIVATE_POST'		=> 'You cannot manage reports of private posts.',
	'NO_REPORT_PRIVATE_POST'			=> 'You cannot report private post.',
	'PRIVATE_TAG'						=> '<a title="This post has been marked as private. Please make sure to not disclose private information!"><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[PRIVATE]</span></a>&nbsp;',

	'FLTL_PRIVATE'		=> '[private post]',
	'BBPREVIEW_PRIVATE'	=> '[private post]',
));
