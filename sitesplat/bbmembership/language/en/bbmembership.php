<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
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
	'BBMEMBERSHIP'						=> 'Memberships',

	'BBMEMBERSHIP_POINTS'  				=> 'Points',
	'CONTINUE_ON_BBPOINTS'				=> 'with BBpoints',
	'CONNECTING_ON_BBPOINTS'			=> 'Validating with BBpoints',
	'CONTINUE_ON_PAYPAL'				=> 'with PayPal',
	'CONNECTING_ON_PAYPAL'				=> 'Connecting with PayPal',
	'PAYPAL_ALT'				        => 'Payments by PayPal',
	'BBMEMBERSHIP_DEPOSIT_DISCLAIMER'   => '**Transactions can take any time from seconds to 24h to validate. For memberships superior to %s100, or for urgent matters, please contact the <a href="./memberlist.php?mode=contactadmin">Board Admin</a>',
	'BBMEMBERSHIP_STATUS'		        => 'Current Membership status:',
	'BBMEMBERSHIP_EXPIRED_INFO'			=> 'N/A',
	'DAYS_TO_EXPIRATION'				=> array(
		0								=> '%1$s days',
		1								=> '%1$s day',
		2								=> '%1$s days'
	),
	
	'BBMEMBERSHIP_PURCHASED'			=> 'Purchased', 
	'BBMEMBERSHIP_PENDING'			    => 'Pending',
	'BBMEMBERSHIP_TAX_TEXT'			    => 'Includes taxes and/or fees',
	'BB_CURRENCY_ZERO_ZERO'			    => '00',
	'BB_CURRENCY_ZERO_ZERO_DEC'			=> '.00',

	'MEMBERSHIP_LEVEL'					=> 'Membership Lv',
    'MEMBERSHIP_ENDS_IN'				=> 'Ends in:',
	'MEMBERSHIP_LIMITED'				=> 'Limited Time Only!',
	'MEMBERSHIP_TIME'					=> 'Membership lifetime (in days)',
	'MEMBERSHIP_UNLIMITED'				=> 'Unlimited',
	'MEMBERSHIP_SUCCESS'				=> 'Thank-you for subscribing with a membership! Your transaction should be validated shortly.',
	'MEMBERSHIP_FAILED_POINTS'			=> 'You do not have enough points for this membership!',
	'MEMBERSHIP_FAILED_PP'				=> 'There was an error with the transaction. Please contact the forum Admin',
	'MEMBERSHIP_DOUBLE'					=> 'You have already purchased a package',
	'MEMBERSHIP_CANCELED'				=> 'Membership canceled',
	'PRIVATE_BOARD'					    => 'PRIVATE BOARD',
	'MEMBERSHIP_NO_AUTH'				=> 'You are not authorized to use this url!',
	'BBMEMBERSHIP_CLUBMODE'				=> 'To access the board you will need to buy a valid membership. This board is private and available only for premium members.'
));
