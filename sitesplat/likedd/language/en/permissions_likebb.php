<?php
/**
*
* phpBB Ajax likeBB.
*
* @copyright (c) 2015 SiteSplat All rights reserved
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

// User Permissions
$lang = array_merge($lang, array(
	'ACL_U_LIKEBB_LIKE'	    => 'Can like posts via LikeBB',
	'ACL_U_LIKEBB_DISLIKE'	=> 'Can dislike posts via LikeBB',
));