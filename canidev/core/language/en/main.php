<?php
/**
* [English [En]]]
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
	'ACCEPT'					=> 'Accept',
	'ALL_GROUPS'				=> 'All groups',
	'BATCH_ACTIONS'				=> 'Batch actions',
	'CONFIGURE'					=> 'Configure',
	'DOCUMENTATION_AND_SUPPORT'	=> 'Documentation and Support',
	'EDIT'						=> 'Edit',
	'NO_ITEMS'					=> 'No items to show',
	'REPORT_EXPLAIN'			=> 'List below as much information as you can about the error.<br /><br />
		In addition to what is described here, basic information about the execution environment will be sent for the correct review of the problem.<br />
		<a href="https://www.canidev.com/api/report/documentation" onclick="window.open(this.href); return false;">View details</a>',
	'REPORT_SENDED'				=> 'Report sent successfully',
	'REPORT_TITLE'				=> 'Report error',
	'SAVE'						=> 'Save',
	'SEND'						=> 'Send',

	// Errors
	'ERROR_REPORT_SEND'			=> 'Your report could not be sent',
));
