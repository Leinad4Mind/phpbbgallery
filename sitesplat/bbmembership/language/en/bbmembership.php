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
	'BBMEMBERSHIP'						=> 'Memberships',

	'BBMEMBERSHIP_POINTS'  				=> 'Points',
	'CONTINUE_ON_BBPOINTS'				=> 'with BBpoints',
	'CONNECTING_ON_BBPOINTS'			=> 'Validating with BBpoints',
	'CONTINUE_ON_PAYPAL'				=> 'with PayPal',
	'CONNECTING_ON_PAYPAL'				=> 'Connecting with PayPal',
	'BBMEMBERSHIP_DEPOSIT_DISCLAIMER'   => '**For memberships superior $100, please contact the <a href="./memberlist.php?mode=contactadmin">Board Admin</a>',
	'BBMEMBERSHIP_STATUS'		        => 'Current Membership status',
	'BBMEMBERSHIP_EXPIRED_INFO'			=> 'Expired!',
	'BBMEMBERSHIP_TAX_TEXT'			    => 'Includes taxes and or fees',
	'BB_CURRENCY_ZERO_ZERO'			    => '00',
	'BB_CURRENCY_ZERO_ZERO_DEC'			=> '.00',

	'MEMBERSHIP_LEVEL'					=> 'Membership Lv',
	'MEMBERSHIP_UNLIMITED'				=> 'Unlimited',
	'MEMBERSHIP_SUCCESS'				=> 'Thank-you for subscribing with a membership! Your transaction should be validated shortly.',
	'MEMBERSHIP_FAILED_POINTS'			=> 'You do not have enough points for this membership!',
	'MEMBERSHIP_FAILED_PP'				=> 'There was an error with the transaction. Please contact the forum Admin',
	'MEMBERSHIP_DOUBLE'					=> 'You have already purchased a package',
	'PRIVATE_BOARD'					    => 'PRIVATE BOARD',
	'BBMEMBERSHIP_CLUBMODE'				=> 'To access the board you will need to buy a valid membership. This board is private and available only for premium members.'
));
