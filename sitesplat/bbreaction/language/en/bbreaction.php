<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
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
	'BBREACTION'						=> 'BBreaction',
	'BBREACTION_TOP_LIST'				=> 'Reactions Toplist',
	'BBREACTION_OTHERS'				    => 'Others?',
	
	'BBREACTION_WHAT'					=> 'What\'s your reaction',
	'BBREACTION_MODE_ERROR'				=> 'Mode does not exist',
	'BBREACTION_POST_ERROR'				=> 'Post does not exist',
	'BBREACTION_POST_NO_AUTH'			=> 'You are not authorized to react to this post.',
	'BBREACTION_OWN_POST_ERROR'			=> 'You cannot react to your own post.',
	'BBREACTION_TIME_ERROR'				=> 'You can not react to a post so fast!',
	'BBREACTION_REMOVED'				=> 'Your reaction has been removed',
	'REMOVED'							=> 'removed',
	'BBREACTION_ADDED'					=> 'Your reaction has been saved',
	'ADDED'								=> 'added',
	'INFOMSG'						    => 'Heads up!',
	
	'REACTIONS_POSITIVE'				=> 'Positive reactions',
	'REACTIONS_NEGATIVE'				=> 'Negative reactions',
	
	'REACTIONS_FORUM_OVERVIEW'			=> 'Forum overview',
	'REACTIONS_TOPIC_OVERVIEW'			=> 'Topic overview',
	'REACTIONS_POSTS_OVERVIEW'			=> 'Message overview',
	'REACTIONS_USER_OVERVIEW'			=> 'User overview',
	
	'BBREACTION_GIVVEN'					=> 'Given',
	'BBREACTION_RECIEVED'				=> 'Received',
	'BBREACTION_NO_RECORDS'				=> 'No reactions available yet',
	'UCP_BBREACTION_EXPLAIN'			=> 'An overview of reactions given and received',
	'ACL_U_BBREACTION'					=> 'Can use BBreaction',
	'ACL_U_BBREACTION_MODULE'           => 'Can use BBreaction UCP module and BBreaction Toplist page',
	
	'NOTIFICATION_TYPE_BBREACTIONS_ADD'	=> 'Someone reacted to your post',
	
	'BBREACTION_NOTI_EVENT_ADDED'		=> '<strong>BBreaction update</strong>:<br />A reaction has been %1$s to your post by %2$s.',
));