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
	'BBPOINTS'						=> 'BBpoints', // This is the forum point name. You can edit it to reflect your own point name.
	'YOUR_BBPOINTS'					=> 'Your BBpoints',
	'BB_AMOUNT'			    		=> 'Amount',
	'BB_PAID_UP'			    	=> 'Paid-up',
	'TOPIC_HIDDEN'					=> 'Hidden topic. Requires a payment',
	'WAS_HIDDEN'					=> 'This is a payed up topic',
	'BBPOINTS_HIDE_TOPIC'	        => 'Points Min.',
	'BBPOINTS_HIDE_TOPIC_EXPLAIN'	=> 'Enter the Minimum Points required for the next user to read this topic. <br />(The points will be transfered to your account)',
	'TRANSFER_NOTI'			        => 'You have received a donation of %1$s from %2$s %3$s',

	'NOTIFICATION_TYPE_SITESPLAT.BBPOINTS.NOTIFICATION.TYPE.TRANSFER' => 'Someone transfered you BBpoints.',
	'NOTIFICATION_TYPE_BBPOINTS_TRANSFER' => 'Someone transfered you BBpoints',
));
