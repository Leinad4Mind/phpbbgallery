<?php
/**
*
* @package PMnotifications
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
	'FROM_AUTHOR_PM_LIST'		=> 'Previous PM\'s from this user',
	'PM_UNREAD_COUNT'	=> array(
		0	=> 'No unread PMs. Great!',
		1	=> '1 unread PM',
		2	=> '%d unread PMs',
	),
));
