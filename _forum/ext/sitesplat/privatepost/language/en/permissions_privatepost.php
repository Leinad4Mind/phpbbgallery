<?php
/**
*
* Private Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
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
	'ACL_U_SEEPRIVATEPOSTS'	=> 'Can read private posts',
));
