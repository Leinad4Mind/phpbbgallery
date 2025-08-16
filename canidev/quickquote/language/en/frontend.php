<?php
/**
* frontend.php [English [En]]
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
));