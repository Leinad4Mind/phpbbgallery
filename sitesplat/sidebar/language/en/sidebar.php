<?php
/**
*
* @package BBSidebar
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
	'ACP_SIDEBAR_SLOTS'	=> 'Sidebar',
	'NEWEST_TOPICS'		=> 'Newest Posts',
	'NO_TOPIC_EXIST'	=> 'No posts exist for viewing',
	'TOP_POSTERS'		=> 'Top active users',
	'NEWEST_USERS'		=> 'Newest users',
	'IN'                => 'In',
    'BBPOINTS_TRANSFER' => 'Transfer points',

	'SIDEBAR_ALL_TIME'	=> 'All-time',
	'SIDEBAR_DAILY'		=> 'Daily',
	'SIDEBAR_WEEKLY'	=> 'Weekly',
	
	'BORN'				=> 'Born',
	'NEW_DOWNLOADS'		=> 'Newest',
	'POP_DOWNLOADS'		=> 'Popular',

	'CALENDAR'			=> 'Calendar',
	'CLOCK'				=> 'Time',
	'LIKEDD'			=> 'Last likes',
	
	'LAST_BADGES'		=> 'Last badges',	
	'SIDEBAR_BADGE'		=> 'Badge name',
	'SIDEBAR_DATE'		=> 'Date',
	'LAST_BBREACTIONS'	=> 'Last BBreactions',
	'SIDEBAR_REACTION'	=> 'Reaction type',
	'BBPOINTS'			=> 'BBpoints',
	'POLL'				=> 'Last poll',
	'NEWSLETTER'		=> 'Newsletter',
	'SIGN_IN_NEWS'		=> 'Sign in for our newsletter',
	'SUBSCRIBE_BTN'		=> 'Subscribe',
	'DOWNLOADS'			=> 'Downloads',
	'UNREAD'			=> 'unread',
	
	'INFOMSG'			=> 'Information',
	'VOTE_NOT_POSIIBLE'	=> 'Change of votes not possible',
	'VOTE_SAVED'		=> 'Your vote is saved',
	'VOTE_CHANGED'		=> 'Your vote is changed',
	'NOT_FOUND'			=> 'Your poll is not found',
	
	'STAFF'				=> 'Staff online',
	'STAFF_UNKNOWN'	    => 'N/A',
	
	'DONATIONS'			=> 'Donations',
	'DONATE_ALSO'		=> 'Ready to donate? Awesome! here you go.',
	'MEMBERSHIPS'		=> 'Memberships',
	'MEMBERSHIPS_CTA'	=> 'Got your Membership package yet?',
	'HOT_TOPICS'		=> 'Hot topics'
));