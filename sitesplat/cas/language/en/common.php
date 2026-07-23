<?php
/**
* @package Categorize CAS
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
	'GLOBAL_ANNOUNCEMENTS'	=> 'Global Announcements',
	'STICKY'				=> 'Stickies',
));
