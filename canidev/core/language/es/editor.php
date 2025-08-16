<?php
/*
* editor.php [Spanish [Es]]
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
