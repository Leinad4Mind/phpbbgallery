<?php
/**
 * [Spanish [Es]]
 * @package cBB Debugger
 * @version 1.0.2 11/03/2024
 *
 * @copyright (c) 2024 CaniDev
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
	'ERROR_MSG'		=> 'Se ha producido un error.<br />La extensión no se ha posido habilitar.',
	'EXPLAIN'		=> 'Utilice esta página para habilitar el modo depuración si no puede acceder al Panel de Administración de su foro.',
	'ENABLE'		=> 'Habilitar',
	'RETURN'		=> 'Volver',
	'SUCCESS_MSG'	=> 'Modo depuración habilitado con éxito',
	'TITLE'			=> 'Modo depuración',
]);
