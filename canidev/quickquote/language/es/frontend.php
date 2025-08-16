<?php
/**
* frontend.php [Spanish [Es]]
*
* @package language cBB QuickQuote
* @version 1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'QQ_INSERT'				=> 'Insertar',
	'QQ_INSERT_ALL'			=> 'Insertar todo',
	'QQ_INSERT_QUOTES'		=> 'Insertar citas',
	'QQ_INSERT_SELECTED'	=> 'Insertar seleccionados',
	'QQ_REMOVE'				=> 'Eliminar',
	'QQ_REMOVE_ALL'			=> 'Eliminar todo',
	'QQ_REMOVE_SELECTED'	=> 'Eliminar seleccionados',
	'QQ_REPLY'				=> 'Responder',
	'QQ_SAVE_QUOTE'			=> 'Guardar cita',
	'QUOTES'				=> 'Citas',
));