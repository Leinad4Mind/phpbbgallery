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

if ( empty($lang) || !is_array($lang) )
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'UCP_BBPOINTS_EXPLAIN'					=> 'Transactions Overview of your earned points',
	'BB_DONATION'							=> 'Donation from',
	'BB_TRANSFER'							=> 'Transfer to',
    'BBPOINTS_LOG'							=> 'BBpoints Log',
	'BBPOINTS_TRANSFER_AMT'					=> 'Transfer amount',
	'TRANSFER_DESCR'						=> 'Comment',  
	'BBPOINTS_COMMENT_PLACEHOLDER'			=> 'Optional comment about the transaction',
	'BBPOINTS_NO_RECORDS'			        => 'Sorry, there are no records yet!',
	
	'BBPOINTS_STATS'						=> 'Statistics',
	'BBPOINTS_STATS_BAR'					=> 'and overall progress goal',
	'BBPOINTS_GOAL'							=> 'Points goal',
	'BBPOINTS_GOAL_TO_GO'					=> 'more to go!',

	'EARN_PER_TOPIC'						=> 'You can earn <strong>%1$s</strong> per topic',
	'EARN_PER_POST'							=> 'You can earn <strong>%1$s</strong> per post',
	'EARN_PER_WORD'							=> 'You can earn <strong>%1$s</strong> per word',
	
	'TRANSFER_TO'							=> 'Here you can transfer/donate points to another user - Cannot be reversed!',
	'TRANSFER_SUCCESS'						=> 'The transfer was successful.',
	'TRANSFER_TO_HIDDEN_TOPIC'				=> 'To read and react to this topic you have to donate: <span class="label label-primary">%1$s</span> <br />This is a one time fee to the Topic starter<br />**Please note, this fee can be asked again if the topic is edited',
	'NO_USER_SELECTED'						=> 'You did not select any user',
	'NO_AMOUNT_SELECTED'					=> 'You did not select any amount or the amount is < 5',           
	'TRANSFER_NOT_ENOUGH_POINTS'			=> 'You do not have enough points to transfer.',

	'POINTS_RETURN_POST'				 	 => 'Return to the topic',
	'POINTS_RETURN_INDEX'				 	 => 'Return to the index',
	'POINTS_RETURN_TRANSFER'		 		 => 'Return to the transfer',
	'POINTS_MAIN'						     => '%s overview',
	'POINTS_MODIFY'						     => 'Modify',
	'POINTS_DONATE'						     => 'Donate',	
	'POINTS_DISABLED'            			 => 'BBpoints is currently disabled',
	
	'POINTS_RECEIVED_POST_MESSAGE'			 => 'You have received <strong>%1$s %2$s</strong> for this topic',
	'POINTS_RECEIVED_REPLY_MESSAGE'		     => 'You have received <strong>%1$s %2$s</strong> for this post',
	'POINTS_RECEIVED_POST_MOD_MESSAGE'		 => 'You will receive <strong>%1$s %2$s</strong> for this topic when it will be approved',
	'POINTS_RECEIVED_REPLY_MOD_MESSAGE'		 => 'You will receive <strong>%1$s %2$s</strong> for this post when it will be approved',
	'POINTS_POST_REMOVED'		             => 'You have lost <strong>%1$s %2$s</strong> for deleting this post',
	
	'TRANSFER_DISABLED'						 => 'Transfer is disabled',
	'TRANSFER_USERNAME_NOT_EXIST' 			 => 'There is no user with this username.',
	'TRANSFER_PM_SUBJECT'				     => 'You have received a donation!',
	'TRANSFER_PM_BODY'					     => 'You have received a donation of %1$s %2$s.',
	'TRANSFER_PM_BODY_COMMENT'	             => 'You have received a donation of %1$s %2$s with the following comment: <br />%3$s',
	'TRANSFER_POINTS_TITLE'				     => 'Transfer %s',
	'TRANSFER_POINTS'						 => 'Transfer %s',   
	'TRANSFER_AMOUNT'						 => 'Amount',
	'TRANSFER_COMMENT'						 => 'Comment',
	'BBPOINT_LOG'						     => 'Transfer log',
	
	
	'CHANGE_NO_USER_SELECTED'			     => 'No user selected',
	'CHANGE_SUCCESS'					     => 'The user has been updated.',
	'CHANGE_POINTS'						     => 'Change %s',
	'CHANGE_AMOUNT'						     => 'New amount',
	
	'MAIN_HELLO'				             => 'Hello %s !',
	'MAIN_TEXT'				                 => 'You have %1$s %2$s.<br /><br />%2$s per new topic: %3$s<br />%2$s per new post: %4$s<br />%2$s per word: %5$s',
));
