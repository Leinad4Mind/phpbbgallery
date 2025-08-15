<?php
/**
*
* @package BBSwitch
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
	'ACCOUNTSWITCH'				=> 'Accountswitch',
	'ACCOUNTSWITCH_EXPLAIN'		=> 'Create accounts and use the same email address, your accounts will be listed here and you can switch from one account to another.',
	'ACCOUNTSWITCH_NO_RECORDS'	=> 'No accounts known',
	'SWITCH_TO'					=> 'Switch to',
	'SWITCH_ALT'				=> 'Alt',
));
