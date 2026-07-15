<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
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
	'DONATIONS'						=> 'Donations',
	'DONATION'						=> 'Donation',
    'DONATIONS_INDEX'				=> 'Donations',
	'DONATION_DISABLED'				=> 'Donations are disabled',
	'DONATIONS_DONATE'  			=> 'Donate',
    'DONATIONS_CONTACT_PAYPAL'		=> 'Please Wait…',
    'DONATIONS_AMOUNT'  			=> 'Amount',
    'DONATIONS_DATE'				=> 'Date',
	'DONATIONS_CUSTOM_MESSAGE'		=> 'Leave a message',
    'DONATIONS_SUCCESS' 			=> 'Donation was successful',
    'DONATIONS_CANCELLED' 			=> 'Donation was cancelled',
    'DONATIONS_ERROR' 				=> 'There was an error in the donation',
	
	'DONATIONS_THANK_YOU'			=> 'Thank-you for supporting our community!',
	'DONATIONS_PREMIUM'				=> 'The donors with an amount of <strong>%s</strong> or more are added to a special group with special forum benefits.<br />Custom rank, color and much more!',
	'DONATIONS_MESSAGE'				=> 'Participate in our success and together let\'s make our community even better',
	'DONATION_STEP_1'				=> '1',
	'DONATION_STEP_2'				=> '2',
    'DONATION_STEP_3'				=> '3',
	'DONATION_STEP_4'				=> '4',
	
	'DONATION_STEP_1_INNER'		    => 'Select a deposit amount',
	'DONATION_STEP_2_INNER'		    => 'Continue securely on PayPal',
    'DONATION_STEP_3_INNER'	        => 'Return to the board',
	'DONATION_STEP_4_INNER'		    => 'Enjoy',
	
	'DONATION_DEPOSIT_DISCLAIMER'   => '**Pay securely with PayPal and <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">CoinBase</a>',
	'DONATION_MY_CREDITS'		    => 'Already donated',
	
	'DONATIONS_NOGUESTS'		    => 'The Board requires you to login before proceeding with a donation',
	'DONATIONS_TRANSACTION'		    => 'Transactions',
	'DONATIONS_TRAN'		        => 'Transaction ',
	'DONATIONS_SENDER'		        => 'Sender',
	'DONATIONS_DIGIT'		        => '.00',
	'DONATIONS_DONORS'		        => 'Last recent donors',
	'DONATIONS_MSG_PLACEHOLDER'		=> 'Optional short message...',
	
	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
	'CONNECTING_ON_PAYPAL'		    => 'Connecting with PayPal',
	'BBDONATION_COPY'		        => 'BBdonation Built With',
	'SITESPLAT_EXT_COPY'	        => 'Professional Web Development and Premium Themes',
	
	'UCP_DONATION_TITLE'			=> 'Donation overview',
	'UCP_DONATIONS_EXPLAIN'         => 'Your donation transactions log',
	'DONATION_ACTIVITY_UCP_EMPTY'   => 'You have no transactions'
));
