<?php
/**
*
* BBOAuth
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
	$lang = [];
}

$lang = array_merge($lang, [
	'BBOAUTH_LOGIN_VIA' => 'logged-in via:',
]);
