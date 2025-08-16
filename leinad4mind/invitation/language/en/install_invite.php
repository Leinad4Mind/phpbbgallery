<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
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
// Some characters you may want to copy&paste: ’ « » „ “ ” …

$lang = array_merge($lang, array(
	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',

	'CACHE_PURGE'							=> 'Clear forum cache',
	'CAT_INSTALL'							=> 'Install',
	'CAT_OVERVIEW'							=> 'Overview',
	'CAT_UNINSTALL'							=> 'Uninstall',
	'CAT_UPDATE'							=> 'Update',
	'CAT_VERIFY'							=> 'Verify',

	'GPL'									=> 'General Public License',

	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
	'INSTALLATION'							=> 'phpBB Invite install',
	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
	'INSTALL_LOGIN'							=> 'Proceed to ACP',

	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',

	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',

	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',

	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
	'NOT_MODULE'							=> 'The installation modules are not available!',
	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',

	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',

	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',

	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',

	'STAGE_INSTALL'							=> 'Install',
	'STAGE_INTRO'							=> 'Intro',
	'STAGE_UNINSTALL'						=> 'Delete the database',
	'STAGE_VERIFY'							=> 'Verify',
	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
	'SUB_INTRO'								=> 'Intro',
	'SUB_LICENSE'							=> 'License',
	'SUB_SUPPORT'							=> 'Support',
	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',

	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
	'UPDATE_TITLE'							=> 'Updating database data',

	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
	'VERIFY_NOT_CONFIG'						=> 'Missing config',
	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
	'VERIFY_NOT_FILE'						=> 'Missing files',
	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
	'VERIFY_NOT_MODULE'						=> 'Missing modules',
	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
	'VERIFY_NOT_TABLE'						=> 'Missing table',
	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
	'VERIFY_TITLE'							=> 'phpBB Invite control',
	'VERIFY_TITLE_ELL'						=> 'Control error',
	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
	'VERIFY_NEW'							=> 'Check again',
	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
));
