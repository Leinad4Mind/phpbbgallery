<?php
/*
* main.php [Spanish [Es]]
* @package Ext Common Core
* @version v1.0.8 12/01/2021
*
* @copyright (c) 2021 CaniDev
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