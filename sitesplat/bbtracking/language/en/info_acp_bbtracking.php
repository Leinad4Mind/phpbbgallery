<?php
/**
*
* BBtracking
*
* @copyright (c) 2017, Sitesplat
* @license private
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
	'ACP_BBTRACKING'			=> 'BBtracking',
	'ACP_BBTRACKING_EXPLAIN'	=> 'Here you can add user to be tracked (or full groups). Users or groups will be then tracked across the board when particular actions are triggered that could be useful to understand the user behavior. <br />',
	'ACP_BBTRACKING_SETTINGS'	=> 'BBtracking Settings',
	'ACP_BBTRACKING_LOGS'		=> 'BBtracking Logs',
	'ACP_BBTRACKING_LOGS_EXPLAIN'		=> 'The users or groups tracked movements can be seen below.',

	'USER_UNTRACKED'	=> 'User has been untracked.',
	'TRACKED_UPDATED'	=> 'Tracking list has been updated.',

	'ADD_USER'			=> 'Add user',
	'TRACKED_USERS'		=> 'Tracked users',
	'TRACKED_USERS_EXPLAIN'		=> 'Add single users to be tracked',
	'TRACKED_GROUPS'	=> 'Tracked groups',
	'TRACKED_GROUPS_EXPLAIN'	=> 'Select a specific group to be tracked',

	'TRACKING_TYPE'	=> 'Tracking type',
	'ALL'			=> 'All',

	'TRACKING_TYPE_ACCOUNT_SETTINGS'		=> '<b>Changed account settings.</b><br>» New username: %s. New email: %s. Changed username: %s. Changed email: %s. Changed password: %s.',
	'TRACKING_TYPE_VIEWFORUM'				=> '<b>Visited <a href="%s">forum ID %d (start %d)</a>.</b>',
	'TRACKING_TYPE_VIEWTOPIC'				=> '<b>Visited <a href="%s">topic ID %d (start %d)</a> in <a href="%s">forum ID %d</a>.</b>',
	'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE'	=> '<b>Viewed <a href="%s">user ID %d`s profile</a>.</b>',
	'TRACKING_TYPE_EDIT_POST'				=> '<b>Edited <a href="%s">post ID %d</a>.</b>',
	'TRACKING_TYPE_LOGIN'					=> '<b>Logged in.</b>',
	'TRACKING_TYPE_LOGOUT'					=> '<b>Logged out.</b>',
	'TRACKING_TYPE_SEND_PM'					=> '<b>Sent PM to user IDs: %s.</b>',

	'TRACKING_TYPE_ACCOUNT_SETTINGS_LABEL'			=> 'Changed account settings',
	'TRACKING_TYPE_VIEWFORUM_LABEL'					=> 'Viewforum visit',
	'TRACKING_TYPE_VIEWTOPIC_LABEL'					=> 'Viewtopic visit',
	'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE_LABEL'	=> 'Member profile view',
	'TRACKING_TYPE_EDIT_POST_LABEL'					=> 'Post edit',
	'TRACKING_TYPE_LOGIN_LABEL'						=> 'Login',
	'TRACKING_TYPE_LOGOUT_LABEL'					=> 'Logout',
	'TRACKING_TYPE_SEND_PM_LABEL'					=> 'PM send',

	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBTRACKING_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension can be found under the "EXTENSIONS" tab.<br />Note: other extension options are under: ACP > Forums: "select your forum" and hit the green cog icon to enter edit mode. Then check out "Store post revisions" and "Auto-prune revisions". <br/>Also, don\'t forget to check the "Group forum permissions" under the "Actions" permission tab.<br /> Finally, the users (who have permissions) can use the post revision option in viewtopic, under the single post dropdown menu.</p></div>',
	
	'ACP_PRIMEPOSTREVISIONS_ENABLE'				=> 'Store post revisions',
	'ACP_PRIMEPOSTREVISIONS_ENABLE_EXPLAIN'		=> 'Keep a revision history of all posts edits.',

	'ACP_PRIMEPOSTREVISIONS_AUTOPRUNE'			=> 'Auto-prune revisions',
	'ACP_PRIMEPOSTREVISIONS_AUTOPRUNE_EXPLAIN'	=> 'Automatically delete post revisions older than the given number of days. Set to 0 to disable.',

	'LOG_PRIMEPOSTREVISIONS_AUTOPRUNE'			=> '<strong>Auto-pruned post revisions</strong><br />» Revisions deleted: %d',
));
