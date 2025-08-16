<?php
/*
* [Spanish [Es]]
* @package cBB Debugger
* @version v1.0.0 21/06/2021
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
	'ACP_DEBUGGER'			=> 'Depuración',
	'ACP_DEBUGGER_EXPLAIN'	=> 'Desde aquí puede habilitar el modo depuración (o debug) del foro, así como otras opciones de estadísticas.',

	'DEBUG_ENABLE'				=> 'Habilitar depuración',
	'DEBUG_ENABLE_EXPLAIN'		=> 'Define si se habilita el modo depuración o (mode debug) y se muestran los errores de código del foro y sus extensiones.',
	'DEBUG_SHOW_STATS'			=> 'Mostrar estadísticas',
	'DEBUG_SHOW_STATS_EXPLAIN'	=> 'Define si se mostrarán estadísticas del tiempo de ejecución y uso de recursos en el pié de página.',

	'LOG_DEBUGGER_CONFIG'		=> '<strong>cBB Debugger:</strong> Modificada configuración',

	'CORE_INSTALL_ERROR'	=> 'No ha subido todos los archivos del paquete de instalación o está intentando instalar un paquete antiguo.<br />
		Por favor, asegúrese de subir todos los archivos (incluída la carpeta <em>core</em>) y de utilizar un paquete descargado de la web oficial.',
));
