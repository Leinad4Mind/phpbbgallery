<?php
/**
* [English [En]]
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
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
	'ACP_CAT_QUICKMOD'				=> 'QuickMod',
	'ACP_QUICKMOD_CONFIG'			=> 'Main Configuration',
	'ACP_QUICKMOD_CONFIG_EXPLAIN'	=> 'From here, you can manage the main moderation options.<br />To arrange the buttons, drag it to the correct position in the bottom list. The visibility of the buttons in the viewforum page depends to the user permissions and the topic state.',
	'QM_MAIN_CONFIG'		=> 'Main Configuration',
	'QM_CONFIRM'			=> 'Confirm dialog',
	'QM_CONFIRM_EXPLAIN'	=> 'Enable/Disable the confirm dialog in the quick actions.',
	'QM_BUTTON_MANAGE'		=> 'Manage Quick Buttons',
	
	'QM_TYPE'				=> 'Icon display',
	'QM_TYPE_EXPLAIN'		=> 'Set the display format for the quick actions in the forum.',
	'QM_TYPE_ICON'			=> 'Icons',
	'QM_TYPE_MENU'			=> 'Context menu',
	
	'BUTTONS_AVAILABLE'		=> 'Available buttons',
	'BUTTONS_SELECTED'		=> 'Selected buttons',

	'LOG_QUICKMOD_CONFIG'	=> '<strong>cBB QuickMod:</strong> Configuration Changed',
));
