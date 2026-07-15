<?php
/**
* [English [En]]]
* @package Ext Common Core
* @version 1.1.0 01/06/2022
*
* @copyright (c) 2022 CaniDev
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
	'ACCEPT'					=> 'Accept',
	'ALL_GROUPS'				=> 'All groups',
	'BATCH_ACTIONS'				=> 'Batch actions',
	'CONFIGURE'					=> 'Configure',
	'DOCUMENTATION_AND_SUPPORT'	=> 'Documentation and Support',
	'EDIT'						=> 'Edit',
	'NO_ITEMS'					=> 'No items to show',
	'SAVE'						=> 'Save',
));