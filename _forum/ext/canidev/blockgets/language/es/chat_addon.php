<?php
/*
* chat_addon.php [Spanish [Es]]
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
	'chat_explain'	=> 'Permite utilizar cBB Chat como un bloque en las columnas o mostrar los usuarios conectados al chat.',
));

$lang = array_merge($lang, array(
	'CHAT_ADDON_MODE'		=> 'Modo de visualización',
	'CHAT_MODE_CHAT'		=> 'Sala de chat',
	'CHAT_MODE_USERS'		=> 'Usuarios conectados',
));
