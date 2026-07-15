<?php

/*
* @package phpBB Extension - Discussion Encouragement With Quick Login
* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
* @license GNU General Public License, version 2 (GPL-2.0)
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
	'DISC_ENC_QL_TTL'				=> 'Create an account or sign in to join the discussion',
	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Sign in to join the discussion',
	'DISC_ENC_QL_INF'				=> 'You need to be a member in order to post a reply',

	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Create an account',
	'DISC_ENC_QL_SGN_UP_INF'		=> 'Not a member? register to join our community',
	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Members can start their own topics & subscribe to topics',
	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'It’s free and only takes a minute',

	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Sign in',
));
