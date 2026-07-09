<?php
/**
 * [Spanish [Es]]
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_CAT_CHAT'			=> 'Chat',
	
	'ACP_CHAT_CONFIG'		=> 'Configuración principal',
	'ACP_CHAT_PAGES'		=> 'Administrar páginas',
	'ACP_CHAT_ROOMS'		=> 'Administrar salas',
	'ACP_CHAT_TEXTS'		=> 'Textos estáticos y Reglas',

	'LOG_CHAT_CONFIG'				=> '<strong>cBB Chat:</strong> Modificada configuración principal',
	'LOG_CHAT_EXCLUSION_ADDED'		=> '<strong>cBB Chat:</strong> Exclusiones añadidas <br />» %s',
	'LOG_CHAT_EXCLUSION_REMOVED'	=> '<strong>cBB Chat:</strong> Exclusiones eliminadas <br />» %s',
	'LOG_CHAT_MESSAGE_MOVED'		=> '<strong>cBB Chat:</strong> Mensaje movido de <em>%1$s</em> a <em>%2$s</em><br />» %3$s',
	'LOG_CHAT_MESSAGES_MOVED'		=> [
		1 => '<strong>cBB Chat:</strong> 1 mensaje movido de <em>%1$s</em> a <em>%2$s</em>',
		2 => '<strong>cBB Chat:</strong> %3$d mensajes movidos de <em>%1$s</em> a <em>%2$s</em>',
	],
	'LOG_CHAT_MESSAGE_REMOVED'		=> '<strong>cBB Chat:</strong> Mensaje eliminado <br />» <em>%s</em>',
	'LOG_CHAT_MESSAGES_REMOVED'		=> [
		1 => '<strong>cBB Chat:</strong> 1 mensaje eliminado de <em>%1$s</em>',
		2 => '<strong>cBB Chat:</strong> %2$d mensajes eliminados de <em>%1$s</em>',
	],
	'LOG_CHAT_ROOM_REMOVED'			=> '<strong>cBB Chat:</strong> Eliminada sala <em>%s</em> y todos sus mensajes',
]);
