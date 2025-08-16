<?php
/*
* [English [En]]
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ERROR_MSG'		=> 'An error occurred.<br />The extension could not be enabled.',
	'EXPLAIN'		=> 'Use this page to enable debugging mode if you cannot access the Administration Panel of your forum.',
	'ENABLE'		=> 'Enable',
	'RETURN'		=> 'Return',
	'SUCCESS_MSG'	=> 'Debug mode enabled successfully',
	'TITLE'			=> 'Debug Mode',
));
