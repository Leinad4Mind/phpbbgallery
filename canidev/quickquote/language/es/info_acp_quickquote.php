<?php
/**
* info_acp_quickquote.php [Spanish [Es]]
* @package cBB QuickQuote
* @version 1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
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
	'ACP_CAT_QUICKQUOTE'			=> 'QuickQuote',
	'ACP_QUICKQUOTE_CONFIG'			=> 'Configuración',
	'ACP_QUICKQUOTE_CONFIG_EXPLAIN'	=> 'Desde aquí puede administrar las opciones principales de la extensión.',
	
	'MAIN_OPTIONS'					=> 'Opciones principales',
	'QUICKQUOTE_FLOATBTN'			=> 'Botón flotante',
	'QUICKQUOTE_FLOATBTN_EXPLAIN'	=> 'Si se habilita, se mostrará un botón en la parte inferior de todas las páginas permitidas, mostrando las citas guardadas.
		En caso contrario, se mostrará un botón en el editor para insertar las citas',
	'QUICKQUOTE_GROUPS'				=> 'Grupos autorizados',
	'QUICKQUOTE_GROUPS_EXPLAIN'		=> 'Define los grupos que podrán utilizar esta extensión.<br />
		Puede seleccionar varios grupos usando la tecla <em>Ctrl</em> de su teclado.<br /><br />
		<em>Aparte de con este parámetro, el uso de la extensión estará condicionado por los permisos para publicar mensajes.</em>',
	'QUICKQUOTE_HELP'				=> 'Documentación y Soporte',
	
	'ALL_GROUPS'	=> 'Todos los grupos',
	'SAVE'			=> 'Guardar',
));
