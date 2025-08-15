<?php
/**
*
* BBpoints extension for the phpBB Forum Software package.
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

$lang = array_merge($lang, array(
	'ACP_POINTS'							=> 'BBpoints',
	'ACP_POINTS_INDEX_TITLE'				=> 'BBpoints Settings',
	'ACP_POINTS_INDEX_EXPLAIN'				=> 'Assign point per topic, post or words or assign them per forum basis via Forums Management. You can exclude forums from BBpoints as well.<br /> Give points to groups of your choice or even by single user. Synchronize and rest point at your wish. Have Fun and make your baord unique and engaging for your users!<br /><br /><strong>NOTE</strong>: The Hide Topic feauture, allows a user to set a minimum amount of point for the topic to be viewable for the next user. It needs to be set by forum group permission. "User can hide own topic" ',
    'ACP_ENABLE_POINTS'					    => 'Enable BBpoints',
	
	'POINTS_NAME'							=> 'Points Symbol (or name)',
	'POINTS_NAME_EXPLAIN'					=> 'Choose the currency symbol. This will shows on different places on the forum<br /> Left and right position can also be selected.<br /> You can easily use your own custom point name by editing one line of the language file located in:<br /> <strong>root/ext/sitesplat/bbpoints/language/bbpoints_common.php</strong>',
	
	'EXT_SYMBOL'							=> 'Extension Symbol',
	'EXT_SYMBOL_EXPLAIN'					=> 'Choose the symbol for this extension',
	
	'ACP_POINTS_EXPLAIN'					=> 'Set how much points a user will receive in general. These values will be overridden if a different value is entered in forum management. <strong>ACP > FORUMS > Your forum</strong> Then click edit for existent forums or find the BBpoints setting for new forums.',
	'ACP_POINTS_PER_EXPLAIN'				=> 'Set how much points a user will receive per login, registration or on his birthday. Set to 0 to switch off.',

	'POINTS_PERLOGIN'						=> 'Points per login',
	'POINTS_PERREGISTER'					=> 'Points on new registrations',
	'POINTS_PERBIRTHDAY'					=> 'Birthday points',
	
	'ENABLE_STATS'							=> 'Enable statistics',
	'ENABLE_STATS_EXPLAIN'					=> 'Enable or disable overall statistics',
	'BAR_STATS'								=> 'Display progress bar on Index',
	'BAR_STATS_EXPLAIN'						=> 'Display a progress bar and your points amount goal on the index page',
	
	'BBPOINT_STATS'							=> 'Display BBpoints statistics on index page',
	'BBPOINT_STATS_EXPLAIN'					=> 'Display user statistics on the index page',

	'TRANSFER_NOTIFY'						=> 'Allow transfer',
	'TRANSFER_NOTIFY_EXPLAIN'				=> 'Allow and notify user, when somebody sends bbpoints to him or her',
	'POINTS_GROUP_TRANSFER_NO_AMOUNT'		=> 'You have to set the amount of points to transfer',
	'POINTS_GROUP_TRANSFER_SUCCESS'			=> 'Transfer has been processed successfully',
	'POINTS_GROUP_TRANSFER_NO_USERS'		=> 'There are no users in this group',
	'POINTS_COMMENTS'						=> 'Allow comments',
	'POINTS_COMMENTS_EXPLAIN'				=> 'Allow user to leave the comment about the points transfer',

	'ACP_POINTS_VERSION'	                => '1.2.4',
    'ACP_LOADING'			                => 'Hold On. Loading...',
	'ACP_SIDEBAR_NOTICE_CLOSE'			    => 'Close',

	'SITESPLAT_COM'		                    => 'https://sitesplat.com',
	'SITESPLAT_COPY'		                => '&#169; SiteSplat',
	'LICENSE_INFO'		                    => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'			        => 'Developer',
	
	'BBPOINTS_NOTICE'						=> '<div style="width:80%;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.<br />Don\'t forget to check Forum Group Permissions and also the Forums Management options!</p></div>',
	'SS_HELPER_NOTY'	                    => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	
	'POINTS_DESCRIPTION'					=> 'BBpoints allows your forum members to have fun and collect points for determined actions...',
	'POINTS_TASKS_1'						=> 'Points per topic, post, words, upon new registrations, birthdays and more!',
	'POINTS_TASKS_2'						=> 'Transfer/donate points to other users',
	'POINTS_TASKS_3'						=> 'Granular points control configurable for each forum',
	'POINTS_TASKS_4'						=> 'Synchronize and reset points',
	'POINTS_TASKS_5'						=> 'UCP Overview of your points with log',
	'POINTS_TASKS_6'						=> 'Synchronization with cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a> extension',


	'FORUM_PERPOST'						       => 'Points per post',
	'FORUM_PERPOST_EXPLAIN'			           => 'Set how much points users will receive for creating a new post.',
	'FORUM_PERPOST_FORUM_EXPLAIN'			   => 'Set how much points users will receive for creating a new post in this forum. If you set 0, default option will be used.',
	'FORUM_PERWORD'						       => 'Points per word',
	'FORUM_PERWORD_EXPLAIN'			           => 'Set how much points users will receive for every word in the post.',
	'FORUM_PERWORD_FORUM_EXPLAIN'			   => 'Set how much points users will receive for every word in the post in this forum. If you set 0, default option will be used.',
	'FORUM_PERTOPIC'					       => 'Points per topic',
	'FORUM_PERTOPIC_EXPLAIN'		           => 'Set how much points users will receive for creating a new topic.',
	'FORUM_PERTOPIC_FORUM_EXPLAIN'		       => 'Set how much points users will receive for creating a new topic in this forum. If you set 0, default option will be used.',
	'POINTS_TRANSFER'					       => 'Allow users to transfer points',
	'POINTS_TRANSFER_EXPLAIN'		           => 'Allow users to transfer their points to another user',
	
	'POINTS_CONFIG_SUCCESS'					   => 'BBPoints settings have been updated successfully',
	
	'POINTS_GROUP_TRANSFER'                    => 'Transfer points to group or single user',
	'POINTS_GROUP_TRANSFER_EXPLAIN'            => 'Start typing the username you wish to send the points to or select the group',
	'POINTS_GROUP_TRANSFER_PM_ERROR'           => 'You have to enter the subject as well as the message to send the PM to the group.',
	'POINTS_GROUP_TRANSFER_GROUP'              => 'Group',
	'POINTS_GROUP_TRANSFER_AMOUNT'             => 'Amount',
	'POINTS_GROUP_TRANSFER_AMOUNT_EXPLAIN'     => 'Enter the amount you would like to transfer to the group or user',
	'POINTS_SMILIES'                           => 'Smilies',
	'POINTS_GROUP_TRANSFER_PM_TITLE'           => 'Personal message subject',
	'POINTS_GROUP_TRANSFER_PM_TITLE_EXPLAIN'   => 'Enter a PM Subject about the transfer',
	'POINTS_GROUP_TRANSFER_PM_COMMENT'         => 'Personal message text',
	'POINTS_GROUP_TRANSFER_PM_COMMENT_EXPLAIN' => 'Enter a PM message about the transfer',
	'POINTS_GROUP_TRANSFER_FUNCTION'           => 'Function',
	'POINTS_GROUP_TRANSFER_ADD'                => 'Add',
	'POINTS_GROUP_TRANSFER_SET'                => 'Set',
	'POINTS_GROUP_TRANSFER_REMOVE'             => 'Remove',
	
	'SYNC_POINTS_CONFIRM'						=> 'Are you sure, you want to synchronize all points?<br />Note: This can not be undone!',
	'SYNC_POINTS'								=> 'Synchronize users points',
	'LOG_RESYNC_SUCCESS'                    	=> 'BBPoints has been reset succesfully',
	'RESET_POINTS_CONFIRM'						=> 'Are you sure, you want to reset all points?<br />Note: This can not be undone!',
	'RESET_POINTS'								=> 'Reset users points',
	
	'RESET_POINTS_EXPLAIN'						=> 'This action cannot be undone! it will reset the users points',
	'SYNC_POINTS_EXPLAIN'				        => 'Calculates all the points criteria set above for all the users.<br />It can take several minutes and it depends on how many users and posts your baord hosts.<br /> Do NOT interrput the process once started.',
	
));
