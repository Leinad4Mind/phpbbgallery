<?php
/*
* frontend.php [Spanish [Es]]
* @package cBB QuickQuote
* @version v1.0.2 21/04/2021
*
* @copyright (c) 2021 CaniDev
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
	'QQ_INSERT'				=> 'Insertar',
	'QQ_INSERT_ALL'			=> 'Insertar todo',
	'QQ_INSERT_QUOTES'		=> 'Insertar citas',
	'QQ_INSERT_SELECTED'	=> 'Insertar seleccionados',
	'QQ_REMOVE'				=> 'Eliminar',
	'QQ_REMOVE_ALL'			=> 'Eliminar todo',
	'QQ_REMOVE_SELECTED'	=> 'Eliminar seleccionados',
	'QQ_REPLY'				=> 'Responder',
	'QQ_SAVE_QUOTE'			=> 'Guardar cita',
	'QUOTES'				=> 'Citas',

	'CORE_INSTALL_ERROR'	=> 'No ha subido todos los archivos del paquete de instalación o está intentando instalar un paquete antiguo.<br />
		Por favor, asegúrese de subir todos los archivos (incluída la carpeta <em>core</em>) y de utilizar un paquete descargado de la web oficial.',
));
