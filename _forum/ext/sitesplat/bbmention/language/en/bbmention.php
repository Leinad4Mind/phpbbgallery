<?php
/**
*
* @package   BB@mention
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

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'NOTIFICATION_BBMENTION'      => '<strong>Mentioned</strong> by %1$s in:',
	'NOTIFICATION_TYPE_BBMENTION' => 'Someone mentions you (or a group you lead) in a post',
]);
