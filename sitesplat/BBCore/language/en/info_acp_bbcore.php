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
	'UPD_MANAGER_MSG'		        => 'Save yourself ton of time and Download the new BBCore Auto-Update to get your themes updated in one-click!<br /><a href="https://sitesplat.com" target="_blank">BBCore Auto-Update</a> (Make sure you are logged in)',
	
	'DOWNLOAD_MSG'					=> 'The current version <span class="label label-success">%s</span> can be downloaded from Themeforest: <a href="%s" title="Download" target="_blank">%s - phpBB3</a>',
	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">https://sitesplat.com</a>',
	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="https://sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
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
	
	// Emoji stuff
	'SS_DEFAULT_EMOJI'				=> 'Default topic titles emoji behavior',
	'SS_DEFAULT_EMOJI_EXPLAIN'		=> 'Enable or disable the default phpBB topic title emoji behavior. Sadly starting with phpBB 3.2.9 users can freely "spam" emojis in topic titles. The phpBB team decided to blindly allow this and offer no way for admins to control it (not cool!). Luckily, you are using the SiteSplat\'s BBCore for added functionality to phpBB :-). It is strongly recommended to leave this option enabled to avoid users spamming titles.<br>Use then: <strong><a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=29" target="_blank">BBemoji</a></strong> (a premium extension) instead if you wish to take this a step further and have total control via proper forum permission basis for this behavior. This way you can designate a specific forum to allow emojis being posted in topic titles.',

));
