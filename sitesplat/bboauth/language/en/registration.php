<?php
/**
*
* BBOAuth
*
* @copyright (c) 2018 SiteSplat All rights reserved
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
	'AGREE_AND_REGISTER'	=> 'Agree with terms and Register with %s',
	'OAUTH_ACCOUNT_ADDED'	=> 'Thank-you for registering, your account has been created via the social media selected and you have been automatically logged-in!',
));
