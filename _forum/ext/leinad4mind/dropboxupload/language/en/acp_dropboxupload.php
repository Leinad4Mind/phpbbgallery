<?php
/**
 * @package Dropbox Upload
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'CREATE_NEW_APP' => 'Create a Dropbox application',
	'CREATE_NEW_APP_TEXT' => 'Create an app-folder application, enable the files.content.write scope, and obtain offline OAuth credentials.',
	'DROPBOX_UPLOAD_ENABLE' => 'Enable Dropbox upload',
	'DROPBOX_UPLOAD_EXPLAIN' => 'Upload verified Auto Database Backup files to Dropbox. Remote files are never deleted by this extension.',
	'DROPBOX_UPLOAD_OPTIONS' => 'Dropbox upload options',
	'DROPBOX_FOLDER' => 'Dropbox folder',
	'DROPBOX_FOLDER_EXPLAIN' => 'Optional relative folder inside the Dropbox application folder. Nested folders are supported.',
	'DROPBOX_FOLDER_OPTIONS' => 'Folder organization',
	'DROPBOX_FOLDER_OPTIONS_EXPLAIN' => 'Optionally add a date-based subfolder.',
	'DROPBOX_FOLDER_DEFAULT' => 'Configured folder only',
	'DROPBOX_FOLDER_CURRENT_DAY' => 'Current day',
	'DROPBOX_FOLDER_DAY_OF_WEEK' => 'Day of week',
	'DROPBOX_FOLDER_WEEK_NO' => 'Week number',
	'DROPBOX_FOLDER_MONTH' => 'Month',
	'DROPBOX_FOLDER_YEAR' => 'Year',
	'DROPBOX_FOLDER_MONTH_YEAR' => 'Month and year',
	'DROPBOX_FREQUENCY' => 'Upload frequency',
	'DROPBOX_FREQUENCY_EXPLAIN' => 'Upload every nth successful local backup, from 1 to 25.',
	'DROPBOX_REFRESH_AUTH' => 'Recommended offline authorization',
	'DROPBOX_REFRESH_AUTH_EXPLAIN' => 'For unattended backups, enter the app key, app secret and refresh token. Blank fields keep the stored value.',
	'DROPBOX_APP_KEY' => 'Dropbox app key',
	'DROPBOX_APP_KEY_EXPLAIN' => 'OAuth client identifier for the Dropbox application.',
	'DROPBOX_APP_SECRET' => 'Dropbox app secret',
	'DROPBOX_APP_SECRET_EXPLAIN' => 'OAuth client secret. This value is never displayed after saving.',
	'DROPBOX_REFRESH_TOKEN' => 'Dropbox refresh token',
	'DROPBOX_REFRESH_TOKEN_EXPLAIN' => 'Offline OAuth refresh token. This value is never displayed after saving.',
	'DROPBOX_ACCESS_TOKEN' => 'Legacy access token',
	'DROPBOX_ACCESS_TOKEN_EXPLAIN' => 'Fallback for an existing long-lived access token. Refresh-token authorization is recommended.',
	'DROPBOX_CREDENTIAL_CONFIGURED' => 'Configured',
	'DROPBOX_CREDENTIAL_NOT_CONFIGURED' => 'Not configured',
	'DROPBOX_CREDENTIAL_CLEAR' => 'Remove stored value',
	'DROPBOX_FOLDER_INVALID' => 'The Dropbox folder is invalid.',
	'DROPBOX_FOLDER_OPTION_INVALID' => 'The Dropbox folder option is invalid.',
	'DROPBOX_FREQUENCY_INVALID' => 'The upload frequency must be between 1 and 25.',
	'DROPBOX_CREDENTIAL_INVALID' => 'A Dropbox credential contains invalid data or is too long.',
	'DROPBOX_CREDENTIALS_REQUIRED' => 'Configure either an access token or complete refresh-token credentials before enabling uploads.',
	'DROPBOX_REFRESH_CREDENTIALS_INCOMPLETE' => 'App key, app secret and refresh token must be configured together.',
));
