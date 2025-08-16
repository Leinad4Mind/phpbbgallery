<?php
/** 
* info_mcp_chat.php [Spanish [Es]]
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
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
	'MCP_CHAT_BAN'				=> 'Exclusiones del Chat',
	
	'CHAT_BAN_CELL'				=> 'Nombre de Usuario',
	'CHAT_BAN_CELL_EXPLAIN'		=> 'Para especificar más de un nombre de usuario ingrese cada uno en una nueva línea.<br />
		Use el enlace <em><u>Buscar un usuario</u></em> para encontrar y añadir usuarios automáticamente.',
	'CHAT_BAN_LIST'				=> 'Usuarios excluidos',
	'CHAT_EXCLUSIONS_ADDED'		=> 'Las exclusiones han sido modificadas',
	'CHAT_EXCLUSIONS_DELETED'	=> 'Las exclusiones han sido eliminadas',
	'CHAT_EXCLUSIONS_ERROR'		=> 'Se ha producido un error, verifique los datos introducidos',
	
	'LOG_CHAT_EXCLUSION_ADDED'		=> '<strong>cBB Chat:</strong> Exclusiones añadidas <br />» %s',
	'LOG_CHAT_EXCLUSION_REMOVED'	=> '<strong>cBB Chat:</strong> Exclusiones eliminadas <br />» %s'
));
