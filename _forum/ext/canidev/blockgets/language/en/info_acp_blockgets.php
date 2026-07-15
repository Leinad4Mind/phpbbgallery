<?php
/*
* [English [En]]
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

/**
 * @general tags and messages
*/
$lang = array_merge($lang, array(
	'ACP_BLOCKGETS'				=> 'Blockgets',
	'ACP_BLOCKGETS_GENERAL'		=> 'General',
	
	'ACP_BLG_CONFIG_MAIN'		=> 'General configuration',
	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Additional configuration',
	'ACP_BLG_IMAGES'			=> 'Images',
	'ACP_PAGES_AND_BLOCKS'		=> 'Pages and Blocks',
	
	// Logs
	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Changed main configuration',
	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> New block added<br />» %1$s in %2$s',
	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks copied<br />» de %1$s a %2$s',
	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Changed blocks position<br />» %1$s',
	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks moved<br />» from %1$s to %2$s',
	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Block(s) deleted<br />» en %1$s',
	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Block edited<br />» %1$s en %2$s',
	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Event deleted<br />» %1$s',
	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> List deleted<br />» %1$s',
	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> New page added<br />» %1$s',
	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Changed page<br />» %1$s',
	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Page deleted<br />» %1$s',
	
	// Permissions
	'ACL_A_BLOCKGETS_MANAGE'	=> 'Can manage cBB Blockgets',
	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Can view calendar',
	'ACL_U_BLOCKGETS_EVENTS'	=> 'Can manage calendar events',
));
