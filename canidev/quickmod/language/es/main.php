<?php
/**
* [Spanish [Es]]
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
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
	'APPROVE_TOPIC'			=> 'Aprobar',
	'CHANGE_ICON'			=> 'Cambiar icono',
	'CHANGE_ICON_TOPIC'		=> 'Cambiar icono',
	'CHANGE_POSTER_TOPIC'	=> 'Cambiar autor',
	'CHANGE_TIME_TOPIC'		=> 'Cambiar fecha de publicación',
	'DISAPPROVE_TOPIC'		=> 'Desaprobar',
	
	'CONFIRM_CHANGE_TOPIC'		=> '¿Está seguro de querer modificar el tema seleccionado?',
	'CONFIRM_CHANGE_TOPICS'		=> '¿Está seguro de querer modificar los temas seleccionados?',
	'CONFIRM_DELETE_TOPIC'		=> '¿Está seguro de querer eliminar el tema seleccionado?',
	'CONFIRM_DELETE_TOPICS'		=> '¿Está seguro de querer eliminar los temas seleccionados?',
	'CONFIRM_LOCK_TOPIC'		=> '¿Está seguro de querer cerrar el tema seleccionado?',
	'CONFIRM_LOCK_TOPICS'		=> '¿Está seguro de querer cerrar los temas seleccionados?',
	'CONFIRM_RENAME_TOPIC'		=> '¿Está seguro de querer renombrar el tema seleccionado?',
	'CONFIRM_RENAME_TOPICS'		=> '¿Está seguro de querer renombrar los temas seleccionados?',
	'CONFIRM_RESTORE_TOPIC'		=> '¿Está seguro de querer restaurar el tema seleccionado?',
	'CONFIRM_RESTORE_TOPICS'	=> '¿Está seguro de querer restaurar los temas seleccionados?',
	'CONFIRM_UNLOCK_TOPIC'		=> '¿Está seguro de querer desbloquear el tema seleccionado?',
	'CONFIRM_UNLOCK_TOPICS'		=> '¿Está seguro de querer desbloquear los temas seleccionados?',
	
	'DELETE_TOPIC'				=> 'Eliminar',
	'DELETE_PERMANENTLY_TOPIC'	=> 'Eliminar permanentemente',
	'LOCK_TOPIC'				=> 'Cerrar',
	'MAKE_ANNOUNCE_TOPIC'		=> 'Marcar como anuncio',
	'MAKE_GLOBAL_TOPIC'			=> 'Marcar como anuncio global',
	'MAKE_NORMAL_TOPIC'			=> 'Marcar como normal',
	'MAKE_STICKY_TOPIC'			=> 'Marcar como fijo',
	
	'MARK_ANNOUNCE'			=> 'Marcar anuncios',
	'MARK_BY_STATUS'		=> 'Marcar por estado',
	'MARK_BY_TYPE'			=> 'Marcar por tipo',
	'MARK_GENERAL'			=> 'General',
	'MARK_GLOBAL'			=> 'Marcar anuncios globales',
	'MARK_LOCKED'			=> 'Marcar temas cerrados',
	'MARK_MOVED'			=> 'Marcar temas movidos',
	'MARK_NORMAL'			=> 'Marcar temas normales',
	'MARK_STICKY'			=> 'Marcar fijos',
	'MARK_TOPICS'			=> 'Marcar temas',
	'MARK_UNLOCKED'			=> 'Marcar temas abiertos',
	
	'MOVE_TOPIC'			=> 'Mover',
	'NO_TOPIC_SELECTED'		=> 'No ha seleccionado ningún tema',
	'OPTIONS_BASIC'			=> 'Opciones Básicas',
	'OPTIONS_ADVANCED'		=> 'Opciones Avanzadas',
	'RENAME_TOPIC'			=> 'Renombrar',
	'RESTORE_TOPIC'			=> 'Restaurar',
	'TOPIC_TYPE'			=> 'Tipo de tema',
	'UNLOCK_TOPIC'			=> 'Desbloquear',

	'ICON'					=> 'Icono',
	'NOTHING'				=> 'No se ha realizado ningún cambio',
	'SELECT_ACTION'			=> 'Seleccionar acción',
	'WITH_SELECTED'			=> 'Con los seleccionados',

	'AUTHOR_CHANGE_SUCCESS'	=> 'El autor de los temas ha sido modificado correctamente.',
	'TOPIC_RENAMED_SUCCESS'	=> 'El tema ha sido renombrado correctamente.',
	
	'CORE_INSTALL_ERROR'	=> 'No ha subido todos los archivos del paquete de instalación o está intentando instalar un paquete antiguo.<br />
		Por favor, asegúrese de subir todos los archivos (incluída la carpeta <em>core</em>) y de utilizar un paquete descargado de la web oficial.',
));
