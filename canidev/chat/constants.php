<?php
/*
* @name constants.php
* @package cBB Chat
* @version v1.1.0 16/12/2014
*
* @copyright (c) 2014 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

define('CHAT_GUEST_ROOM',	1);

define('CHAT_TEXT_NOTICE', 	1);
define('CHAT_TEXT_TIP', 	2);
define('CHAT_TEXT_RULE', 	3);

define('CHAT_STATUS_AVAILABLE',	1);
define('CHAT_STATUS_AWAY',		2);
define('CHAT_STATUS_BUSY',		3);
define('CHAT_STATUS_HIDDEN',	4);

define('CHAT_MESSAGES_TABLE', 		$table_prefix . 'chat_messages');
define('CHAT_PAGES_TABLE', 			$table_prefix . 'chat_pages');
define('CHAT_ROOMS_TABLE',			$table_prefix . 'chat_rooms');
define('CHAT_TEXTS_TABLE', 			$table_prefix . 'chat_texts');
define('CHAT_USERS_TABLE', 			$table_prefix . 'chat_users');
