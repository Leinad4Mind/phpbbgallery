<?php
/*
* frontend.php [English [En]]
* @package cBB QuickQuote
* @version v1.0.2 21/04/2021
*
* @copyright (c) 2021 CaniDev
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
	'QQ_INSERT'				=> 'Insert',
	'QQ_INSERT_ALL'			=> 'Insert all',
	'QQ_INSERT_QUOTES'		=> 'Insert quotes',
	'QQ_INSERT_SELECTED'	=> 'Insert selected',
	'QQ_REMOVE'				=> 'Remove',
	'QQ_REMOVE_ALL'			=> 'Remove all',
	'QQ_REMOVE_SELECTED'	=> 'Remove selected',
	'QQ_REPLY'				=> 'Reply',
	'QQ_SAVE_QUOTE'			=> 'Save quote',
	'QUOTES'				=> 'Quotes',

	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
));
