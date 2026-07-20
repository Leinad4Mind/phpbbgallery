<?php

/**
 * @package language cBB Blockgets for phpBB.
 * @version v2.0.1 04/05/2018
 * @copyright (c) 2018 CaniDev
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

// @ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang['blocks']))
{
	$lang['blocks'] = [];
}

$lang['blocks'] = array_merge($lang['blocks'], [
	'chat_title'   => 'Chat',
	'chat_explain' => 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
]);

$lang = array_merge($lang, [
	'CHAT_ADDON_MODE' => 'Display mode',
	'CHAT_MODE_CHAT'  => 'Chat room',
	'CHAT_MODE_USERS' => 'Online Users',
]);
