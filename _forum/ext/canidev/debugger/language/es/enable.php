<?php
/*
* [Spanish [Es]]
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ERROR_MSG'		=> 'Se ha producido un error.<br />La extensión no se ha posido habilitar.',
	'EXPLAIN'		=> 'Utilice esta página para habilitar el modo depuración si no puede acceder al Panel de Administración de su foro.',
	'ENABLE'		=> 'Habilitar',
	'RETURN'		=> 'Volver',
	'SUCCESS_MSG'	=> 'Modo depuración habilitado con éxito',
	'TITLE'			=> 'Modo depuración',
));
