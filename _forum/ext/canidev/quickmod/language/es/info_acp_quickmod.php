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
	'ACP_CAT_QUICKMOD'				=> 'QuickMod',
	'ACP_QUICKMOD_CONFIG'			=> 'Configuración principal',
	'ACP_QUICKMOD_CONFIG_EXPLAIN'	=> 'Desde aquí puede administrar las opciones generales de moderación.<br />Para ordenar los botones arrástrelos a la posición deseada de la lista de abajo. La visibilidad de estos botones en la lista de temas del foro dependerá de los permisos del usuario y del estado del tema.',
	'QM_MAIN_CONFIG'		=> 'Configuración principal',
	'QM_CONFIRM'			=> 'Pedir confirmación',
	'QM_CONFIRM_EXPLAIN'	=> 'Habilita/Deshabilita el diálogo de confirmación al realizar las acciones rápidas.',
	'QM_BUTTON_MANAGE'		=> 'Administrar botones',
	
	'QM_TYPE'				=> 'Visualización de iconos',
	'QM_TYPE_EXPLAIN'		=> 'Define como se mostrarán las funciones rápidas en el foro.',
	'QM_TYPE_ICON'			=> 'Iconos',
	'QM_TYPE_MENU'			=> 'Menú contextual',
	
	'BUTTONS_AVAILABLE'		=> 'Botones disponibles',
	'BUTTONS_SELECTED'		=> 'Botones seleccionados',

	'LOG_QUICKMOD_CONFIG'	=> '<strong>cBB QuickMod:</strong> Modificada configuración',
));
