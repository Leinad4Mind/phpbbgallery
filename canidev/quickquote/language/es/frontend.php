<?php
/**
 * [Spanish [Es]]
 * @package cBB QuickQuote
 * @version 1.0.5 08/04/2025
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
]);
