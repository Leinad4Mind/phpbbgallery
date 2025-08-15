<?php
/**
*
* @package BBajaxnews
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
	// special
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBDONATION'			=> '%s just made a donation.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBMEMBERSHIP'		=> '%s purchased membership LV%s.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_BBVOTE'				=> 'The best answer has been marked in “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_FRIEND_LOGGED_IN'	=> 'Your friend %s just logged in.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_ANNOUNCEMENT'	=> '%s just published a new announcement “%s” in “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_STICKY'			=> '%s just made topic “%s” sticky in “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_TOPIC'			=> '%s just posted new topic “%s” in “%s”.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_BOARD'	=> '%s just joined the board.',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USER_JOINED_GROUP'	=> '%s just joined the special group %s.',

	// casual
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_NEW_POSTS_TODAY'	=> [
		0	=> 'No posts have been posted so far today.',
		1	=> '1 post has been posted so far today.',
		2	=> '%d posts have been posted so far today.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE_24H'	=> [
		0	=> 'No user was online in the last %dh.',
		1	=> 'There was one user online in the last %2$dh.',
		2	=> 'There were %d users online in the last %dh.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_USERS_ONLINE'	=> [
		0	=> 'There is no one online at this moment.',
		1	=> 'There is currently 1 user online at this moment.',
		2	=> 'There are currently %d users online at this moment.',
	],
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL_NONE'	=> 'You have voted in all polls available. Nice!',
	'SITESPLAT_BBAJAXNEWS_AJAXNEWS_TYPE_RANDOM_POLL'		=> 'There is a poll “%s” waiting for your response.',
));
