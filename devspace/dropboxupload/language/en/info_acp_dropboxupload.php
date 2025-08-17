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
	'DROPBOX_UPLOAD' 			=> 'Dropbox Upload',
	'DROPBOX_UPLOAD_LOG' 		=> '<strong>Dropbox upload settings updated</strong>',
	'DROPBOX_UPLOAD_MANAGE' 	=> 'Dropbox settings',

	'LOG_DROPBOX_ERROR' 		=> '<strong>Dropbox returned the error</strong><br>» %s',
	'LOG_DROPBOX_NO_FILE' 		=> '<strong>The backup file for Dropbox could not be found</strong>',
	'LOG_DROPBOX_UPLOAD' 		=> '<strong>Backup file uploaded to Dropbox<br>»»</strong>%s',
	'LOG_DROPBOX_UPLOAD_FAILED'	=> '<strong>The Dropbox upload failed</strong>',
]);
