<?php
/**
* [Spanish [Es]]
* @package Ext Common Core
* @version 1.1.1 15/01/2023
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
	'AUTHOR'					=> 'Autor:',
	'CODE'						=> 'Código',
	'DATE'						=> 'Fecha:',
	'DESCRIPTION_OPTIONAL'		=> 'Descripción (Opcional):',
	'INSERT'					=> 'Insertar',
	'MAXIMIZE'					=> 'Maximizar editor',
	'PRINT'						=> 'Imprimir',
	'REMOVE_FORMAT'				=> 'Quitar Formatos',
	'UNLINK'					=> 'Quitar Vínculo',
	'URL'						=> 'Url:',
	'VIEW_SOURCE'				=> 'Ver Código',
));
