<?php
/**
* [Spanish [Es]]
* @package Ext Common Core
* @version 1.1.0 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
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

$lang = array_merge($lang, array(
	'ACCEPT'					=> 'Aceptar',
	'ALL_GROUPS'				=> 'Todos los grupos',
	'BATCH_ACTIONS'				=> 'Acciones en lote',
	'CONFIGURE'					=> 'Configurar',
	'DOCUMENTATION_AND_SUPPORT'	=> 'Documentación y Soporte',
	'EDIT'						=> 'Editar',
	'NO_ITEMS'					=> 'No hay elementos para mostrar',
	'SAVE'						=> 'Guardar',
));