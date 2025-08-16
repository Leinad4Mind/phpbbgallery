<?php
/*
* info_acp_blockgets.php [Spanish [Es]]
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

/**
 * @general tags and messages
*/
$lang = array_merge($lang, array(
	'ACP_BLOCKGETS'				=> 'Blockgets',
	'ACP_BLOCKGETS_GENERAL'		=> 'General',

	'ACP_BLG_CONFIG_MAIN'		=> 'Configuración general',
	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Configuración adicional',
	'ACP_BLG_IMAGES'			=> 'Imágenes',
	'ACP_PAGES_AND_BLOCKS'		=> 'Páginas y Bloques',

	// Logs
	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Modificada configuración principal',
	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> Nuevo bloque añadido<br />» %1$s en %2$s',
	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Bloques copiados<br />» de %1$s a %2$s',
	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Modificada posición de bloques<br />» %1$s',
	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Bloques movidos<br />» de %1$s a %2$s',
	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Bloque(s) eliminado(s)<br />» en %1$s',
	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Bloque editado<br />» %1$s en %2$s',
	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Evento eliminado<br />» %1$s',
	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> Eliminada lista<br />» %1$s',
	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> Añadida página<br />» %1$s',
	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Modificada página<br />» %1$s',
	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Eliminada página<br />» %1$s',
	
	// Permissions
	'ACL_A_BLOCKGETS_MANAGE'	=> 'Puede administrar cBB Blockgets',
	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Puede ver el Calendario',
	'ACL_U_BLOCKGETS_EVENTS'	=> 'Puede administrar eventos del Calendario',
));
