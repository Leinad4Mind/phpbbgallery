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
	'ACP_BADGE_MANAGE'					=> 'Manage Badge Award',
	'ACP_BADGE_MANAGE_EXPLAIN'			=> 'Using this form you can add, edit, view and delete Badge Award configurations.',

	'BADGE_DESCRIPTION'					=> 'Award users with badges based on custom and default rules',
	'BADGE_DEVELOPERS'					=> 'Developers',
	'BADGE_TASKS_1'						=> 'Unlimited rules combination ',
	'BADGE_TASKS_2'						=> 'Unlimited Custom rules',
	'BADGE_TASKS_3'						=> 'More badges per rule possible',
	'BADGE_TASKS_4'						=> 'Synchronization with cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a> extension',
	'BADGE_TASKS_5'						=> 'Expandable with AutoGroup functions and many Premium Rules. Checkout the premium rules on <a href="http://www.sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BADGE_TASKS_6'						=> 'Much more..!',
	
	'SITESPLAT_COM'		       		    => 'http://sitesplat.com',
	'SITESPLAT_COPY'		    		=> '&#169; SiteSplat',
	'LICENSE_INFO'		        		=> 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    		=> 'Developer',
	'ACP_SIDEBAR_NOTICE_CLOSE'			=> 'Close',
	
	'ACP_BBAWARDS_VERSION'				=> '1.3.6',
	'ACP_BBAWARDS'						=> 'BBAwards',
    'ACP_LOADING'			    		=> 'Hold On. Loading...',
	
	'ACP_BADGE_ADD'						=> 'Add Badge Award',
	'ACP_BADGE_EDIT'					=> 'Edit Badge Award',

	'AVATAR_EXPLAIN'					=> 'Award a badge to members with an avatar',
	'BADGES_EXPLAIN'					=> 'Award extra badges to members with a minimum of other badges',
	'BIRTHDAYS_EXPLAIN'					=> 'Award badges to members with a birthday',
	'CUSTOM_EXPLAIN'					=> 'Award badges to members you like',
	'DONATION_EXPLAIN'					=> 'Award badges to donators',
	'LIKEDD_EXPLAIN'					=> 'Award badges to members with likes / dislikes given or recieved',
	'MEMBERSHIP_EXPLAIN'				=> 'Award badges to members for their membership',
	'POSTS_EXPLAIN'						=> 'Award badges to posters',
	'PROFILEWALL_EXPLAIN'				=> 'Award badges for profile comments',
	'SIGNATURE_EXPLAIN'					=> 'Award badges to members with a signature',
	'WARNINGS_EXPLAIN'					=> 'Award badges to members with warnings',
	'ZEBRA.FOES_EXPLAIN'				=> 'Award badges to members with foe(s)',
	'ZEBRA.FRIENDS_EXPLAIN'				=> 'Award badges to members with friend(s)',

	'ACP_BADGE_AVAILABLE'				=> 'Available badges',
	'ACP_BADGE_AVAILABLE_EXPLAIN'		=> 'Available badges in your system,<br />hover for rules assign to the badge',
	'ACP_BADGE_RULE_NAME'				=> 'Badge rule',
	'ACP_BADGE_RULE_NAME_EXPLAIN'		=> 'Name of this badge rule',
	'ACP_BADGE_RULE_DESCRIPTION'		=> 'Rule-description',
	'ACP_BADGE_RULE_DESCRIPTION_EXPLAIN'=> 'Description of this rule',
	'ACP_BADGE_IMAGE'					=> 'Badge image',
	'ACP_BADGE_IMAGE_EXPLAIN'			=> 'Select badge image for this rule',
	'ACP_BADGE_CONDITION_NAME'			=> 'Badge Award type',
	'ACP_BADGE_CONDITION_NAME_EXPLAIN'	=> 'Choose the type of condition on which users will get this Badge.',
	'ACP_BADGE_USERLIST'				=> 'Select user(s) for this badge',
	'ACP_BADGE_USERLIST_EXPLAIN'		=> 'Select multiple users by holding <samp>CTRL</samp> and clicking.',
	'ACP_BADGE_MIN_VALUE'				=> 'Min. value',
	'ACP_BADGE_MIN_VALUE_EXPLAIN'		=> 'Users will be get this badge if they exceed the minimum value.',
	'ACP_BADGE_MAX_VALUE'				=> 'Max. value',
	'ACP_BADGE_MAX_VALUE_EXPLAIN'		=> 'Users will loose this award if they exceed the maximum value. Leave this field empty if you do not want this.',
	'ACP_BADGE_VALUE'					=> 'Min- Max value, Boolean',
	'ACP_BADGE_LIKE_DISLIKE'			=> '(Dis)-Like award',
	'ACP_BADGE_LIKE_DISLIKE_EXPLAIN'	=> 'Choose wether to count likes or dislikes',
	'ACP_BADGE_LIKE'					=> 'Likes',
	'ACP_BADGE_DISLIKE'					=> 'Dislikes',
	'ACP_BADGE_GIVEN'					=> 'Given',
	'ACP_BADGE_RECIEVED'				=> 'Recieved',
	'ACP_BADGE_PROFILEWALL'				=> 'Profilewall',
	'ACP_BADGE_PROFILEWALL_EXPLAIN'		=> 'Choose wether to count comment & replies or profilewall-likes',
	'ACP_BADGE_COMMENTS_REPLIES'		=> 'Comment & Replies',
	'ACP_BADGE_LIKES'					=> 'Profilewall-likes',
		
	'ACP_BADGE_NOTIFY'					=> 'Notify user',
	'ACP_BADGE_NOTIFY_EXPLAIN'			=> 'Send a notification to users after being awarded.',
	'ACP_BADGE_NOTICE_CLOSE'			=> 'Close notification',

	'ACP_BADGE_UPLOAD'					=> 'Upload badge',
	'ACP_BADGE_UPLOAD_EXPLAIN'			=> 'Upload your badge, should be a image file of jpg, jpeg, gif or png type.',

	'ACP_BADGE_CREATE_RULE'				=> 'Create new Badge Award',
	'ACP_BADGE_SUBMIT_SUCCESS'			=> 'Badge Award successfully configured.',
	'ACP_BADGE_DELETE_CONFIRM'			=> 'Are you sure you want to delete this Badge Award configuration?',
	'ACP_BADGE_DELETE_SUCCESS'			=> 'Badge Award successfully deleted.',
	'ACP_BADGE_EMPTY'					=> 'There are no badge awards.',
	'ACP_BADGE_NO_IMAGE'				=> 'No badge available',
	'ACP_BADGE_INVALID_VALUE'			=> 'Maximum value below minimum value!',
	'ACP_BADGE_NAME_USED'				=> 'Rulename already used or empty!',
	'NOTICE_LIKEDD'						=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> is not installed, you can NOT use the LikeBB type rule.',
	'NOTICE_DONATIONS'					=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=20"><strong>Forum Donation</strong></a> is not installed, you can NOT use the donation type rule.',
	'NOTICE_PROFILEWALL'				=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=13"><strong>Profile Wall</strong></a> is not installed, you can NOT use the profile wall type rule.',
	'NOTICE_PREMIUM'				    => 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=25"><strong>Premium Rules</strong></a> is not installed, you can NOT use the extra premium type rules.',
));
