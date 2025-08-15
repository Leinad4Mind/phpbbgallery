<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
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

// DEVELOPERS PLEASE NOTE
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
	'BADGE_MANAGE'			    => 'Badge Awards',
	'BADGE_MANAGE_EXPLAIN'	    => 'An overview of all awarded badges',
	'BADGE_RECENT'			    => 'Recent Awards',
	'BADGE_USER'			    => 'User Badge Awards',
	'BADGE_INTRO_TITLE'		    => 'Badge It Up Yo!',
	'BADGE_INTRO_TEASER_BODY'	=> 'Whether you\'ve won a competition, helped around, or even just joined us, we\'re happy to celebrate your contribution to our community.',
	'BADGE_INTRO'	            => 'Whether you\'ve won a competition, helped around, or even just joined us, we\'re happy to celebrate your contribution to our community.',
	'BADGE_AWARDS_TOPIC'	    => 'Awards',
	'BADGE_WALL_TITLE'	        => 'My Awards collection wall',
	
	'UCP_BADGE_TITLE'		    => 'Badge Awards',
	'UCP_BADGE_EXPLAIN'		    => 'An overview of all your awarded badges',

	// Conditions
	'BADGE_TYPE_AVATAR'			=> 'Avatar',
	'BADGE_TYPE_BADGES'			=> 'Badges awarded',
	'BADGE_TYPE_BIRTHDAYS'		=> 'User age',
	'BADGE_TYPE_CUSTOM'			=> 'Custom',
	'BADGE_TYPE_DONATIONS'		=> 'Donations',
	'BADGE_TYPE_LIKEDD'			=> 'LikeBB',
	'BADGE_TYPE_MEMBERSHIP'		=> 'Registration Days',
	'BADGE_TYPE_POSTS'			=> 'Posts',
	'BADGE_TYPE_PROFILEWALL'	=> 'Profilewall',
	'BADGE_TYPE_SIGNATURE'		=> 'Signature',
	'BADGE_TYPE_WARNINGS'		=> 'Warnings',
	'BADGE_TYPE_ZEBRA_FOES'		=> 'Foe',
	'BADGE_TYPE_ZEBRA_FRIENDS'	=> 'Friends',

	'BADGE_USED'				=> 'used',
	'BADGE_BETWEEN'				=> 'between',
	'BADGE_AND'					=> 'and',
	'BADGE_MORE'				=> 'equal or more then',
	'MORE_BADGES'				=> '<a class="badge-more" href="%1$s"><span class="hidden-xs">&#43;%2$s more</span><i class="visible-xs-inline-block fa fa-plus-circle"></i></a>',

	// Notifications
	'BADGE_NOTIFICATION_EVENT_ADDED'	=> '<strong>BBAwards update</strong>:<br />A new %1$s badge has been added.',
	'BADGE_NOTIFICATION_EVENT_REMOVED'	=> '<strong>BBAwards update</strong>:<br />A %1$s badge has been removed.',
	'BADGE_WHOHOO'	                    => 'Whoohoo!!! There is a shiny new badge to celebrate, congrats!<hr><strong>You just unlocked a new badge</strong>, go to <a href="%1$s">your badge page</a> to see them all!',
	
	'NOTIFICATION_TYPE_AWARD_ADDED'	    => 'When an Award has been added',
	'NOTIFICATION_TYPE_AWARD_REMOVED'	=> 'When an Award has been removed',
	
	// Misc
	'BADGE_LINK_AD'	                    => 'BBAwards by SiteSplat',
	'BADGE_LINK_AD_TITLE'	            => 'Professional Premium Themes And Extensions',
));
