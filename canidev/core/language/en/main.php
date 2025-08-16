<?php
/*
* main.php [English [En]]]
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
	'ACCEPT'					=> 'Accept',
	'ALL_GROUPS'				=> 'All groups',
	'DOCUMENTATION_AND_SUPPORT'	=> 'Documentation and Support',
	'EDIT'						=> 'Edit',
	'NO_ITEMS'					=> 'No items to show',
	'SAVE'						=> 'Save',
));