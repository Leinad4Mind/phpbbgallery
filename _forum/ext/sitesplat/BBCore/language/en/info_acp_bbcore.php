<?php
/**
*
* common [English]
*
* @package language
* @package sitesplat BBcore
* @version $Id$
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

// TRANSLATORS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

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
	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'SiteSplat Update Manager',
    'VERSION_INSTALLED'  			=> 'Installed Version',
	'NEW_BOOTS_VERSION'				=> 'New %s version available',
	'VERSIONNUMBERS'				=> 'Installed Version: %s, download the new version from the server: <a style="color:#fff;" href="%s" title="Download" target="_blank">%s</a>',
	'SS_RAPID_DISABLE'				=> 'SS Rapid Disable',
	'SS_RAPID_DISABLE_TLT'		    => 'Disables (all) extensions at once. Make a backup first!!!',
	
	'DOWNLOAD_MSG'					=> 'The current version <span class="label label-success">%s</span> can be downloaded from Themeforest: <a href="%s" title="Download" target="_blank">%s - phpBB3</a>',
	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">http://www.sitesplat.com</a>',
	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
	'NO_VERSIONINFO'				=> 'No version info available at the moment, try again in a few minutes!',

    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed successfully</strong>',
    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed successfully</strong><br />» Some functions may not work!',
    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled successfully</strong>',
  
    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
	
	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed successfully</strong>',
	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore uninstalled successfully</strong>',

	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not uninstall correctly</strong><br />Could NOT replace the following file(s)<br />» %s',
	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install correctly</strong><br />Could NOT update the following file(s)<br />» %s',
    
	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin-log under the MAINTENANCE tab.',
	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server file permissions or missing files. <br />See the admin log for more details.<br /><br />Please update the files permission manually.',
	'BBCORE_ERROR_DISABLE'		    => 'You cannot disable SiteSplat BBCore due to other active SiteSplat\'s extensions.<br />Disable SiteSplat\'s extensions first. (You can use the rapid disable to disable all the SiteSplat\'s extensions at once.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>',

	// minification
	'SITESPLAT_BBCORE_MINIFY_HTML'			=> 'Minify HTML',
	'SITESPLAT_BBCORE_MINIFY_HTML_EXPLAIN'	=> 'This is a BBCore option. Generated content will be minified prior to sending it to the user. This will reduce network traffic but will also increase CPU and memory usage on server side.',

	// autoupdate
	'AUTOUPDATE_CONFIRM'			=> 'Confirm',
	'AUTOUPDATE_CONFIRM_CONFIRM'	=> 'Are you sure you wish to update the theme with the auto-update?<br /><br /><strong>NOTE:</strong> The board will be disabled and the board cache will be automatically cleared for you after the update.<br /> A log of the changes is also saved under the ACP Admin log. <br /> A backup of your style (time stamped) will be stored for your convenience under the phpBB root/store/ folder on your server. <br />Make sure to clear your browser cache after the update and if you use CloudFlare make sure to clear the cache there as well plus clear again the forum cache via ACP.',
    'UPDATE_IN_PROGRESS'			=> 'Update in progress. Do not close this tab.',
	'STYLE_NOT_DEFINED'				=> 'You did not define a style to update.',
	'ALREADY_UP_TO_DATE'			=> 'Your style is already up to date.',
	'NO_DIRECT_DOWNLOAD'			=> 'We are unable to automatically update your style because the style author did not provide the necessary files.',
	'PROBLEM_DOWNLOADING_UPDATE'	=> 'We are unable to download the update files. Please, try again later.',
	'DOWNLOADED_FILE_CORRUPTED'		=> 'The update file is corrupted.',
	'MERGE_CONFLICTS'				=> 'Oh No! 💔😱 ¯\_(ツ)_/¯ We were unable to automatically update your premium theme. The reason is because your theme contains custom changes you or your web developer made and therefore we are unable to automatically solve this. To see the conflicting files and/or conflicts they contain, take a look at saved files in:<br /><br /><strong>%s</strong>.',
	'REQUIRED_FILE_MISSING'			=> 'A required file is missing from your style: %s',
	'NEW_FILE_ALREADY_EXISTS'		=> 'A file to be added already exists: %s',
	'UPDATE_SUCCESS'				=> 'Yeehaw!💯 Your Premium Theme has Been Updated Successfully. Enjoy!<br />Also, don\'t forget to check for any updates of your SiteSplat Premium Extensions.<br /><br /> Oh, if you are really in a fantastic mood now that I made your life easier and faster 😜 how about a digital high 5? like for example a 5 stars ⭐⭐⭐⭐⭐ rating on Themeforest about this Premium Theme with super PRO functions? <br /><br />Pretty Please? 😚 Here is the link for ya: <a href="http://themeforest.net/downloads" target="_blank">http://themeforest.net/downloads</a>',
    'CURRENT_FILE'					=> 'Current file',
	'DIFF_SEP_EXPLAIN'				=> 'Conflict',
	'NEW_FILE'						=> 'New file',

	// log
	'LOG_STYLE_UPDATED'	=> '<strong>Auto-updated %s style</strong><br />Edited:<br />&emsp;%s<br /><br />Added:<br />&emsp;%s<br /><br />Deleted:<br />&emsp;%s',
));
