<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
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
	'NEWSLETTER'				=> 'Newsletter',
	'OVERVIEW'					=> 'Welcome to our Newsletter! :-) On this page you will find the latest Newsletters as well as the past years archives.',

	'SUBSCRIBE_NO'				=> 'I do NOT want to receive the Newsletter anymore',
	'SUBSCRIBE_YES'				=> 'Yes I want to receive the Newsletter',
	'SUBSCRIBE_BTN_NO'			=> 'Cancel',
	'SUBSCRIBE_BTN_YES'			=> 'Subscribe',
	'SUBSCRIBE_CONFIRM_NO'		=> 'Please submit to cancel your subscription',
	'SUBSCRIBE_CONFIRM_YES'		=> 'Please submit to confirm your subscription',

	'SUBSCRIBE_Y_EMAIL'			=> 'Your email',
	'SUBSCRIBE'					=> 'Subscribe to',
	'UNSUBSCRIBE'				=> 'Unsubscribe from',
	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
	
	'OVERVIEW_ARCHIVE'			=> 'Archive',
	'ARCHIEVES'					=> 'Archives',
	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
));
