<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
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
	'THANKS_FOR_CONFIRMING'	=> 'Thanks for confirming that was you! Business as usual then.',
	'ACCOUNT_DISABLED'		=> 'Thanks for the information. Your account has been temporarily disabled, thus secured. Check your email for further information regarding your account.',
));
