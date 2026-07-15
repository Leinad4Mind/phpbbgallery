<?php
/**
 * [English [En]]
 * @package cBB Debugger
 * @version 1.0.2 11/03/2024
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
	'ERROR_MSG'		=> 'An error occurred.<br />The extension could not be enabled.',
	'EXPLAIN'		=> 'Use this page to enable debugging mode if you cannot access the Administration Panel of your forum.',
	'ENABLE'		=> 'Enable',
	'RETURN'		=> 'Return',
	'SUCCESS_MSG'	=> 'Debug mode enabled successfully',
	'TITLE'			=> 'Debug Mode',
]);
