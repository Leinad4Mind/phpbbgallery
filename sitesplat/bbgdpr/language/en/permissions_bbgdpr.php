<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
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
	'ACL_U_DELETE_MY_ACCOUNT_POSTS'	=> 'Can delete posts when deleting account (BBgdpr)',
	'ACL_U_DELETE_MY_ACCOUNT_PMS'	=> 'Can delete PMs when deleting account (BBgdpr)',
));
