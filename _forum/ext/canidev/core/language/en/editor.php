<?php
/*
* editor.php [English [En]]]
* @package Ext Common Core
* @version v1.0.4 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
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
