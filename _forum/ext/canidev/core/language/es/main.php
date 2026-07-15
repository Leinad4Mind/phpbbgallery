<?php
/**
 * [Spanish [Es]]
 * @package Ext Common Core
 * @version 1.1.3 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, array(
	'ACCEPT'					=> 'Aceptar',
	'ALL_GROUPS'				=> 'Todos los grupos',
	'BATCH_ACTIONS'				=> 'Acciones en lote',
	'CONFIGURE'					=> 'Configurar',
	'DOCUMENTATION_AND_SUPPORT'	=> 'Documentación y Soporte',
	'EDIT'						=> 'Editar',
	'ENABLE_DISABLE'			=> 'Activar/Desactivar',
	'NO_ITEMS'					=> 'No hay elementos para mostrar',
	'REPORT_EXPLAIN'			=> 'Detalle a continuación toda la información que pueda sobre el error.<br /><br />
		Además de lo descrito aquí, se enviará información básica sobre el entorno de ejecución para la correcta revisión del problema.<br />
		<a href="https://www.canidev.com/api/report/documentation" onclick="window.open(this.href); return false;">Ver detalles</a>',
	'REPORT_SENDED'				=> 'Reporte enviado con éxito',
	'REPORT_TITLE'				=> 'Reportar error',
	'SAVE'						=> 'Guardar',
	'SEND'						=> 'Enviar',

	// Errors
	'ERROR_REPORT_SEND'			=> 'No ha sido posible enviar su reporte',
));
