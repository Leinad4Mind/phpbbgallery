<?php
/**
*
 * @package ReplyToUnihde
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
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
	// Hide BBCode
	'HIDE_ON'		=> 'Hidden Content',
	'HIDE_OFF'		=> 'Hidden Content (for members only)',
	'HIDE_EXPLAIN'	=> 'This board requires you to be registered, logged-in and to reply first to view the hidden content...',
	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
));
