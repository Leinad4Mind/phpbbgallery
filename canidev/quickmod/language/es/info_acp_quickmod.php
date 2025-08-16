<?php
/**
* info_acp_quickmod.php [Spanish [Es]]
* @package cBB QuickMod
* @version v1.1.1 22/03/2019
*
* @copyright (c) 2019 CaniDev
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
	
	'BUTTONS_AVALIABLE'			=> 'Botones disponibles',
	'BUTTONS_SELECTED'			=> 'Botones seleccionados',
	'DOCUMENTATION_AND_SUPPORT'	=> 'Documentación y Soporte',
	'SAVE'						=> 'Guardar',

	'LOG_QUICKMOD_CONFIG'	=> '<strong>cBB QuickMod:</strong> Modificada configuración',
));
