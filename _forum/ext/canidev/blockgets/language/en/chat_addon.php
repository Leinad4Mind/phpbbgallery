<?php
/*
* chat_addon.php [English [En]]
* @package cBB Blockgets
* @version v2.0.1 04/05/2018
*
* @copyright (c) 2018 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang['blocks']))
{
	$lang['blocks'] = array();
}

$lang['blocks'] = array_merge($lang['blocks'], array(
	'chat_title'	=> 'Chat',
	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
));

$lang = array_merge($lang, array(
	'CHAT_ADDON_MODE'		=> 'Display mode',
	'CHAT_MODE_CHAT'		=> 'Chat room',
	'CHAT_MODE_USERS'		=> 'Online Users',
));
