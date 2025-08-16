<?php
/*
* [English [En]]
* @package cBB Chat
* @version v1.2.4 17/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACL_CAT_CHAT'				=> 'Chat',
	'ACL_A_CHAT'				=> 'Can manage the chat',

	'ACL_M_CHAT_DELETE'			=> 'Can delete messages',
	'ACL_M_CHAT_EDIT'			=> 'Can edit messages',

	'ACL_U_CHAT_ARCHIVE'		=> 'Can view the archive',
	'ACL_U_CHAT_DELETE'			=> 'Can delete own messages',
	'ACL_U_CHAT_EDIT'			=> 'Can edit own messages',
	'ACL_U_CHAT_IGNOREFLOOD'	=> 'Can ignore flood limit',
	'ACL_U_CHAT_POST'			=> 'Can post messages',
	'ACL_U_CHAT_SENDPM'			=> 'Can send private messages',
	'ACL_U_CHAT_VIEW'			=> 'Can view the chat',
));
