<?php
/**
*
* phpBB Ajax likeBB.
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
	'NOTIFICATION_TYPE_SITESPLAT.LIKEDD.NOTIFICATION.TYPE.LIKEDD_ADDED'	=> 'Somebody liked / disliked your post',	

	'LIKE_MODE_ERROR'						    => 'Mode does not exist',
	'LIKE_POST_ERROR'					        => 'Post does not exist',
	'LIKE_POST_NO_AUTH'				            => 'You are not authorized to like/dislike this post.',
	'LIKE_OWN_POST_ERROR'				        => 'You cannot like/dislike your own post.',
	'LIKE_DISLIKE_OFF_INFO'				        => 'Do not be an ass. The dislike option is disabled',
	'LIKE_LIKE_TIME_ERROR'						=> 'You can not like - dislike a post so fast!',
	'LIKE_DISLIKE_REMOVE_INFO'					=> 'To remove your dislike, click the dislike button.',
	'LIKE_LIKE_REMOVE_INFO'						=> 'To remove your like, click the like button.',
	'LIKE_USER_INFO_LIKE'						=> 'like',
	'LIKE_USER_INFO_DISLIKE'					=> 'dislike',
	'ADDED'										=> 'added',
	'REMOVED'									=> 'removed',
	'INFOMSG'					                => 'Heads up!',
	
	'LIKEDD_NOTIFICATION_EVENT_ADDED'			=> '<strong>Like / Dislike update</strong>:<br />A %1$s has been %2$s to your post by %3$s.',
	'LIKE_USER_INFO_REMOVED'				    => 'Your %s of this post has been removed.',
	'LIKE_USER_INFO_APPRECIATE'					=> '%s appreciates your liking their post!',
	'LIKE_USER_INFO_APPRECIATE_STRONG'			=> '<div class="ld-ajax"><strong>%s</strong> appreciates your liking their post!</div>',
	'LIKE_POST_INFO_DISLIKE'					=> 'Post by %s has been disliked.',
	'LIKE_POST_INFO_DISLIKE_STRONG'				=> '<div class="ld-ajax">Post by <strong>%s</strong> has been disliked.</div>',
	'TO_MANY_DISLIKES'		                    => 'This content received too many dislikes. Click <a class="label label-warning label-dsk" href="javascript:void(0)" data-toggle="collapse" data-target=".dkd-wrapper-%s">SHOW</a> to view',
	
	'LIKES_OTHERS'                  			=> 'Others',   
    'LIKES_LIKE_THIS'   	        			=> 'likes this',   
    'LIKES_LIKERS'       	     				=> 'Who liked this post',
	'LIKES_AND'       	     				    => 'and',
	'LIKES_LIKED_LAST'       	     		    => 'liked last!',
	'LIKES_LINK_OTHER_TOOLTIP'       	        => 'See who liked this',
	'LIKES_TOP_LIST'       	                    => 'Top 10 Like / Dislike list',
	
	'LIKE_ACTIVITY_UCP_EMPTY'				    => 'There is no activity yet. What are you waiting for? :-)',
	
	'LIKES_PAGE_TITLE'                  		=> 'Top list',   
    'LIKES_TABLE_TITLE'   	        			=> 'Leaderboard',   
    'LIKES_AUTHOR'       	     				=> 'Author',
	'LIKES_POST_SUBJECT'       	     		    => 'Post/Subject',
	'LIKES_LIKES_DISLIKES'       	     		=> 'likes/dislikes',
	
	'LIKES_SORT_TITLE'       	     		    => 'Sort by Likes/dislikes',
	'LIKES_SORT_LIKES'       	     	     	=> 'Likes',
	'LIKES_SORT_DISIKES'       	     		    => 'Dislikes',
	
	'LIKES_SORT_DATE'       	     		    => 'Sort by date',
	'LIKES_SORT_POSTS_AMT'       	     		=> 'Sort by post',
	
	
	'LIKES_GIVEN'                  				=> 'Like Given',   
    'LIKES_RECEIVED'   	        				=> 'Like Received',   
    'DISLIKES_GIVEN'       	     				=> 'Dislike Given',
    'DISLIKES_RECEIVED'            				=> 'Dislike Received',   
	'LIKE_REMOVED'								=> 'Like removed',
	'DISLIKE_REMOVED'							=> 'Dislike removed',
    'LIKES_LIKE_IT'   	         				=> 'I like This',   
    'LIKES_LIKE'       	         				=> 'Like',
    'LIKES_DISLIKE_IT'       	     			=> 'I Dislike This',
    'LIKES_DISLIKE'       	     				=> 'Dislike',
    'LIKES_DISLIKE_REMOVED'    	     			=> 'Like / Dislike removed',
	'LIKES_ALL_LIKES'							=> 'of all likes',
	'LIKES_ALL_DISLIKES'						=> 'of all dislikes',

	'AND'										=> 'and',
	'OTHERS'									=> 'others',
	'LIKED_THIS'								=> 'liked this',
	
	'UCP_LIKEDD_TITLE'							=> 'Like / Dislike overview',
	'UCP_LIKEDD_EXPLAIN'						=> 'Overview of all likes and dislikes you give or recieved'
));
