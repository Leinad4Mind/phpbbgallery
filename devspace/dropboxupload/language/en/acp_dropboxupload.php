<?php
/**
 *
 * @package Dropbox Upload
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	$lang = [];
}

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'CREATE_NEW_APP' 					=> 'Create a new app on the Dropbox platform',
	'CREATE_NEW_APP_TEXT' 				=> '<strong>To create a new Dropbox app you need to have a Dropbox account.</strong><br>Then go to <a href="https://www.dropbox.com/developers/apps/create">https://www.dropbox.com/developers/apps/create</a> and log in if necessary.<br><br>- Select Dropbox API.<br>- Choose the type of access you need = App folder.<br>- Enter a name for your app.<br>- Click on “Create app”.<br><br>- Go to Oauth2 and click on “Generate access code”<br>- <strong>Make a note of the details on this page and enter them in the form above</strong> (you can go back to this page at any time).',

	'DROPBOX_UPLOAD_ENABLE' 			=> 'Enable Dropbox upload',
	'DROPBOX_FOLDER' 					=> 'Dropbox folder',
	'DROPBOX_FOLDER_EXPLAIN' 			=> 'The Dropbox folder (within the “Apps” folder) where the backups will be uploaded to. Leaving this blank will upload the backups to the app’s root folder.<br>Any folder entered here will be created automatically.',
	'DROPBOX_FOLDER_OPTIONS' 			=> 'Folder options',
	'DROPBOX_FOLDER_OPTIONS_EXPLAIN'	=> 'Select the option for “smart” folder creation.<br>Default will use the folder name entered above whilst any other option will create a folder based on the date options selected.<br>These folders will be created automatically.',
	'DROPBOX_FREQUENCY' 				=> 'Upload frequency',
	'DROPBOX_FREQUENCY_EXPLAIN' 		=> 'How often should the backup be uploaded to Dropbox.<br>Setting this to “1” will result in all backups being uploaded to Dropbox - any other value will mean that every <em>nth</em> backup will be uploaded.',
	'DROPBOX_KEY' 						=> 'Dropbox key',
	'DROPBOX_KEY_EXPLAIN' 				=> 'The Dropbox app key from the Dropbox app.',
	'DROPBOX_SECRET' 					=> 'Dropbox secret',
	'DROPBOX_SECRET_EXPLAIN' 			=> 'The Dropbox app secret key from the Dropbox app.',
	'DROPBOX_TOKEN' 					=> 'Dropbox access token',
	'DROPBOX_TOKEN_EXPLAIN' 			=> 'The Dropbox access token from the Dropbox app.',
	'DROPBOX_UPLOAD_EXPLAIN' 			=> 'Enter here the required parameters to allow files to be uploaded to your Dropbox account.<br><br><strong>Note:This extension does <em>NOT</em> remove any files from the Dropbox account - this will have to be done manually.</strong>',
	'DROPBOX_UPLOAD_OPTIONS' 			=> 'Dropbox upload options',

	'dbx_folder_opts' => [
		'DEFAULT' 		=> 'Default',
		'CURRENT_DAY' 	=> 'Current day',
		'DAY_OF_WEEK'	=> 'Day of week',
		'WEEK_NO' 		=> 'Week number',
		'MONTH' 		=> 'Month',
		'YEAR' 			=> 'Year',
		'MONTH_YEAR' 	=> 'Month/Year',
	],
]);
