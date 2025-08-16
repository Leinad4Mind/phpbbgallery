<?php
/**
 * [English [En]]
 * @package cBB QuickQuote
 * @version 1.0.4 01/06/2024
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
]);
