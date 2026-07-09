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
	'MCP_CHAT_BAN'				=> 'Exclusiones del Chat',
	
	'CHAT_BAN_CELL'				=> 'Nombre de Usuario',
	'CHAT_BAN_CELL_EXPLAIN'		=> 'Para especificar más de un nombre de usuario ingrese cada uno en una nueva línea.<br />
		Use el enlace <em><u>Buscar un usuario</u></em> para encontrar y añadir usuarios automáticamente.',
	'CHAT_BAN_LIST'				=> 'Usuarios excluidos',
	'CHAT_EXCLUSIONS_ADDED'		=> 'Las exclusiones han sido modificadas',
	'CHAT_EXCLUSIONS_DELETED'	=> 'Las exclusiones han sido eliminadas',
	'CHAT_EXCLUSIONS_ERROR'		=> 'Se ha producido un error, verifique los datos introducidos',
	
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
]);
