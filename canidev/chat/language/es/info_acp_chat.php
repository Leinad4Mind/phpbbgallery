<?php
/** 
* info_acp_chat.php [Spanish [Es]]
* @package cBB Chat
* @version v1.1.2 20/08/2016
*
* @copyright (c) 2016 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACP_CAT_CHAT'			=> 'Chat',
	
	'ACP_CHAT_CONFIG'		=> 'Configuración principal',
	'ACP_CHAT_PAGES'		=> 'Administrar páginas',
	'ACP_CHAT_ROOMS'		=> 'Administrar salas',
	'ACP_CHAT_TEXTS'		=> 'Textos estáticos y Reglas',

	'LOG_CHAT_CONFIG'			=> '<strong>cBB Chat:</strong> Modificada configuración principal',
	'LOG_CHAT_ROOM_REMOVED'		=> '<strong>cBB Chat:</strong> Eliminada sala <em>%s</em> y todos sus mensajes',
));
