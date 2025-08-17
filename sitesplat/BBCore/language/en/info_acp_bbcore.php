<?php
/**
*
* common [English]
*
* @package language
* @version $Id$
* @copyright (c) 2014 SiteSplat.com
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    
	'ACP_SITESPLAT_UPDATE_MANAGER'=>  'SiteSplat Update Manager',
    'ACP_SITESPLAT_V_INSTALLED'   =>  'Installed Version',

    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed succesfully</strong>',
    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed succesfully</strong><br />» Some functions may not work!',
    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled succesfully</strong>',
  
    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
    
	
	
	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed succesfully</strong>',
	'LOG_BBCORE_UNINSTALLED'		=> '<strong>Sitesplat BBCore unistalled succesfully</strong>',

	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not unistall succesfully</strong><br />Could NOT replace the following file(s)<br />» %s',
	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install succesfully</strong><br />Could NOT update the following file(s)<br />» %s',
    
	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin-log under the MAINTENANCE tab.',
	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server filepermissions or missing files. <br />See admin log for more details.<br /><br />Please update the files manually to enjoy all functions.',
	
));

?>