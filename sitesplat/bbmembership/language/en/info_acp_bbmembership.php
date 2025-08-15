<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
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
	'ACP_BBMEMBERSHIP_TITLE'				=> 'BBmembership',
	'ACP_BBMEMBERSHIP_EXPLAIN'				=> 'Configure your memberships, you can add up to 4 memberships with different packages. The price for each membership should be different. PayPal and BBpoints (factor 100) are the two allowed payment systems. Configure the groups and the group permissions to make the memberships access different forum areas for example.',
	'ACP_BBMEMBERSHIP_SANDBOX'  			=> 'PayPal sandbox',
	'ACP_BBMEMBERSHIP_SANDBOX_EXPLAIN'  	=> '<a href="https://developer.paypal.com/" target="_blank">More info</a>',
	
	'ACP_BBMEMBERSHIP_CLUBMODE'				=> 'Club Mode',
	'ACP_BBMEMBERSHIP_CLUBMODE_EXPLAIN'		=> 'The user will be allowed to register but only be able to access the board if a membership package is bought succesfully',
	'ACP_BBMEMBERSHIP_PAYPAL_EMAIL'			=> 'Paypal email',
	'ACP_BBMEMBERSHIP_PAYPAL_EMAIL_EXPLAIN'	=> 'PayPal email or SandBox PayPal email if you are using the sandbox mode for testing purposes.',
	'ACP_BBMEMBERSHIP_BBPOINTS'				=> 'BBpoints',
	'ACP_BBMEMBERSHIP_BBPOINTS_EXPLAIN'		=> 'Allow users to purchase the membership with <a href="http://www.sitesplat.com/phpBB3/marketplace.php" target="_blank">BBpoints</a><br />  The moltiplication in bbpoints required for each package is (factor 100). e.g. Currency $5 means 500 BBpoints, $10 means 1000 and so on.',
	
	'ACP_BBMEMBERSHIP_LEVELS'				=> 'Memberships levels',
	'ACP_BBMEMBERSHIP_LEVELS_EXPLAIN'		=> 'Set the membership levels here, min. amount to join, expiry time in days, package description, group and optionally set it as default. <br /> Set expiry time to:<br />  &nbsp;&nbsp;&nbsp;<strong>0</strong> Never expire.  Unlimited Membership <br /> &nbsp;&nbsp;<strong>-1</strong> 5 minutes pass for testing purposes (For example with the PayPal sandbox)<br /> &nbsp;&nbsp;&nbsp;<strong>1</strong> Sets the days with 1 or more. EG, 2 equals 2 days etc <br />Do NOT use decimals. Checkmark the hide option to hide the membership package from the membership page.',

	'ACP_BBMEMBERSHIP_AMT'					=> 'Amount',
	'ACP_BBMEMBERSHIP_EXPIRE'				=> 'Expire',
	'ACP_BBMEMBERSHIP_PACKAGE' 				=> 'Package description',
	'ACP_BBMEMBERSHIP_PACKAGE_LEVEL' 		=> 'Membership Lv',
	'ACP_BBMEMBERSHIP_GROUP'				=> 'Select Group',
	'ACP_BBMEMBERSHIP_DEFAULT'				=> 'Default',
	'ACP_BBMEMBERSHIP_HIDE'					=> 'Hide',
	'ACP_BBMEMBERSHIP_CURRENCY'				=> 'Currency code',
	'ACP_BBMEMBERSHIP_CURRENCY_EXPLAIN'     => 'Currency code follows the allowed <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">Paypal Multiple Currencies</a> standards. <br /> Make sure the currency you are going to use is enabled on your PayPal account. If the currency is not supported on your PayPal acccount the transactions will be returned as "Not verified" ',
 
    'ACP_BBMEMBERSHIP_FLAGS'			    => 'PayPal Flags',
	'ACP_BBMEMBERSHIP_FLAGS_EXPLAIN'		=> 'If a transaction is flagged as <span class="label label-danger">Not verified</span> you can toggle the verification by clicking on the flag and it will be toggled as <span class="label label-success">Completed</span>. This will also automatically move the user to the intended group.<br /> Please make sure to verify the transaction with your PayPal account if the transaction status does not automatically change within 24h and you chose to force a "Completed" status.<br /> An <span class="label label-default">Expired</span> flag is a transaction that has been marked as such automatically by the Synch/Cron system therefore X user is removed from X group(membership level).',
 
	'ACP_BBMEMBERSHIP_SYNC'					=> 'Synchronization',
	'ACP_BBMEMBERSHIP_SYNC_EXPLAIN'			=> 'This will force start a synchronization of the members package levels and groups.<br />Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cron Status Extension</a> to check the cron jobs. <br />Note: the sync automatically flags a "completed" transaction to "expired" if the criteria are met for X user.<br />The synchronization processes in batches of 50. Large forums with many users and memberships may take some time to get to 100% and complete the synchronization.',
	'LAST_MEMBERSHIP_CHECK'					=> 'Last sync on:',
 
	'ACP_BBMEMBERSHIP_TRANSACTIONS'			=> 'transactions',
	'ACP_BBMEMBERSHIP_TOTAL'				=> 'Total amount',
	'ACP_BBMEMBERSHIP_ADDRESS'				=> 'address',
	'ACP_BBMEMBERSHIP_COUNTRY'				=> 'country',
	'ACP_BBMEMBERSHIP_TRANSACTION_ID'		=> 'Tranaction id',
	'ACP_BBMEMBERSHIP_PAY_STATUS'			=> 'Payment status',
	'ACP_BBMEMBERSHIP_EXPIRED'				=> 'Expired',
	'ACP_BBMEMBERSHIP_TIME'					=> 'Payment date & time',
	
	'ACP_BBPOINTS_NOTICE_CLOSE'				=> 'Close',
	'BBPOINTS_NOTICE'						=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>BBpoints</strong></a> is not installed, you can NOT use the BBpoints Cart system.',
    'ACP_BBMEMBERSHIP_SAVE_ERROR'			=> 'Something went wrong while saving your setup, try again!',
	'BBMEMBERSHIP_NOTICE'					=> '<div class="attach-image"><p>Settings for this extension are in <strong>%1$s » %2$s » %3$s</strong>. <br />Setup your memberships and packages first, add PayPal and optionally enable the BBpoints extension for extra functionality.</p></div>',
	
	
	'BBMEMBERSHIP_DESCRIPTION'				=> 'Allows your board to run a true membership system. Optionally make the forum a private club available only for paid memebers. Many unique feautures included the possibility to pay for the membership with a BBpoints.',
	'BBMEMBERSHIP_DEVELOPERS'				=> 'Developers',
	'BBMEMBERSHIP_TASKS_1'					=> 'True membership system',
	'BBMEMBERSHIP_TASKS_2'					=> 'PayPal and BBpoints Gateway',
	'BBMEMBERSHIP_TASKS_3'					=> 'Club mode for private forums',
	'BBMEMBERSHIP_TASKS_4'					=> 'Synchronization with cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a> extension',
	'BBMEMBERSHIP_TASKS_5'					=> 'Expandable with BBpoints functions to allow the members to purchase membership with points. Get the premium BBpoints extension on <a href="http://www.sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBMEMBERSHIP_TASKS_6'					=> 'Much more..!',
	
	'SITESPLAT_COM'		       		        => 'http://sitesplat.com',
	'SITESPLAT_COPY'		    			=> '&#169; SiteSplat',
	'LICENSE_INFO'		        			=> 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    			=> 'Developer',
	'ACP_BBMEMBERSHIP_NOTICE_CLOSE'			=> 'Close',
	
	'ACP_BBMEMBERSHIP_VERSION'				=> '1.4.0',
    'ACP_LOADING'			    			=> 'Hold On. Loading...',
	
));
