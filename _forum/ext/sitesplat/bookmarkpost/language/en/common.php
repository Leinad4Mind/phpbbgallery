<?php
/**
*
* Bookmark Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
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
    'BOOKMARK_POST_TITLE'			=> 'Manage Post Bookmarks',
	'BOOKMARK_POST'			    	=> 'Bookmark this post',
	'UNBOOKMARK_POST'		    	=> 'Unbookmark post',
	'TOOLTIP_BOOMARKED_POSTS'   	=> 'You have a post or more bookmarked in this topic',
	'TOOLTIP_BOOMARKED_FORUM_POSTS' => 'You have a post or more bookmarked in this forum',
	'POST_BOOKMARKED'           	=> 'You bookmarked this post',
	'POST_BOOKMARK_ADDED'	        => 'Post bookmarked successfully.<br><br><a href="%1$s">Return to the topic</a><br><br><a href="%2$s">See all bookmarked posts</a>',
	'POST_BOOKMARK_ADDED_AJAX'		=> 'Post bookmarked successfully.',
	'POST_BOOKMARK_REMOVED'	        => 'Post bookmark removed successfully.<br><br><a href="%1$s">Return to the topic</a><br><br><a href="%2$s">See all bookmarked posts</a>',
	'POST_BOOKMARK_REMOVED_AJAX'	=> 'Post bookmark removed successfully.',
));
