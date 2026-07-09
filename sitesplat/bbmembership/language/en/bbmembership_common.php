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
	'MEMBERSHIPS'						=> 'Memberships',
	'NOTIFICATION_TYPE_BBMEMBERSHIP'	=> 'Membership information notifications',
	'MEMBERSHIP_NOTIFICATION_BOUGHT'	=> '<strong>Membership bought</strong>: %1$s just purchased the membership level %2$s.',
	'MEMBERSHIP_NOTIFICATION_EXPIRING'	=> '<strong>Expiring membership</strong>: %1$s, your current membership will expire in less than 24 hours.',
));
