<?php
/**
 * [Spanish [Es]]
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
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
	'ACP_DEBUGGER'			=> 'Depuración',
	'ACP_DEBUGGER_EXPLAIN'	=> 'Desde aquí puede habilitar el modo depuración (o debug) del foro, así como otras opciones de estadísticas.',

	'DEBUG_ALLOWED_IPS'			=> 'IPs autorizadas',
	'DEBUG_ALLOWED_IPS_EXPLAIN'	=> 'Define las ips desde las que se podrá ver el modo depuración.<br />
		Deje este campo en blanco para que el modo depuración sea visible por todos.<br /><br />
		<em>Debe separar las ips por una coma o establecer cada una en una línea.</em>',
	'DEBUG_ENABLE'				=> 'Habilitar depuración',
	'DEBUG_ENABLE_EXPLAIN'		=> 'Define si se habilita el modo depuración o (debug mode) y se muestran los errores de código del foro y sus extensiones.',
	'DEBUG_SHOW_STATS'			=> 'Mostrar estadísticas',
	'DEBUG_SHOW_STATS_EXPLAIN'	=> 'Define si se mostrarán estadísticas del tiempo de ejecución y uso de recursos en el pié de página.',

	'LOG_DEBUGGER_CONFIG'		=> '<strong>cBB Debugger:</strong> Modificada configuración',

	'CORE_INSTALL_ERROR'	=> 'No ha subido todos los archivos del paquete de instalación o está intentando instalar un paquete antiguo.<br />
		Por favor, asegúrese de subir todos los archivos (incluída la carpeta <em>core</em>) y de utilizar un paquete descargado de la web oficial.',
]);
