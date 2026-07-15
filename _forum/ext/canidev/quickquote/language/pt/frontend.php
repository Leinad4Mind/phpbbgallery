<?php
/**
* frontend.php [Spanish [Es]]
* @package cBB QuickQuote
* @version v1.0.1 10/02/2019
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
	'QQ_INSERT'				=> 'Inserir',
	'QQ_INSERT_ALL'			=> 'Inserir todas',
	'QQ_INSERT_QUOTES'		=> 'Inserir citações',
	'QQ_INSERT_SELECTED'	=> 'Inserir seleccionadas',
	'QQ_REMOVE'				=> 'Eliminar',
	'QQ_REMOVE_ALL'			=> 'Eliminar todas',
	'QQ_REMOVE_SELECTED'	=> 'Eliminar seleccionadas',
	'QQ_REPLY'				=> 'Responder',
	'QQ_SAVE_QUOTE'			=> 'Guardar citação',
	'QUOTES'				=> 'Citações',
));