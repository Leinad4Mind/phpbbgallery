<?php
/*
* editor.php [English [En]]]
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
	'AUTHOR'					=> 'Author:',
	'CODE'						=> 'Code',
	'DATE'						=> 'Date:',
	'DESCRIPTION_OPTIONAL'		=> 'Description (Optional):',
	'INSERT'					=> 'Insert',
	'MAXIMIZE'					=> 'Maximize editor',
	'PRINT'						=> 'Print',
	'REMOVE_FORMAT'				=> 'Remove Format',
	'UNLINK'					=> 'Remove Link',
	'URL'						=> 'Url:',
	'VIEW_SOURCE'				=> 'Show Code',
));
