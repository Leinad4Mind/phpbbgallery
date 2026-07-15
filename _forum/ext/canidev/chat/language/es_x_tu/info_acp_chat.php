<?php
/** 
* info_acp_chat.php [Spanish Casual [es_x_tu]]
* @package cBB Chat
* @version v1.2.0 02/03/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
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

	'LOG_CHAT_CONFIG'				=> '<strong>cBB Chat:</strong> Modificada configuración principal',
	'LOG_CHAT_EXCLUSION_ADDED'		=> '<strong>cBB Chat:</strong> Exclusiones añadidas <br />» %s',
	'LOG_CHAT_EXCLUSION_REMOVED'	=> '<strong>cBB Chat:</strong> Exclusiones eliminadas <br />» %s',
	'LOG_CHAT_MESSAGE_MOVED'		=> '<strong>cBB Chat:</strong> Mensaje movido de <em>%1$s</em> a <em>%2$s</em><br />» %3$s',
	'LOG_CHAT_MESSAGES_MOVED'		=> array(
		1 => '<strong>cBB Chat:</strong> 1 mensaje movido de <em>%1$s</em> a <em>%2$s</em>',
		2 => '<strong>cBB Chat:</strong> %3$d mensajes movidos de <em>%1$s</em> a <em>%2$s</em>',
	),
	'LOG_CHAT_MESSAGE_REMOVED'		=> '<strong>cBB Chat:</strong> Mensaje eliminado <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED'		=> array(
		1 => '<strong>cBB Chat:</strong> 1 mensaje eliminado de <em>%1$s</em>',
		2 => '<strong>cBB Chat:</strong> %2$d mensajes eliminados de <em>%1$s</em>',
	),
	'LOG_CHAT_ROOM_REMOVED'			=> '<strong>cBB Chat:</strong> Eliminada sala <em>%s</em> y todos sus mensajes',
));
