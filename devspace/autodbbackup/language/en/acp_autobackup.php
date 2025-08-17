<?php
/**
*
* @package Auto db Backup
* @copyright (c) 2015 david63
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'AUTO_DB_BACKUP_COPIES'					=> 'Stored backups',
	'AUTO_DB_BACKUP_COPIES_EXPLAIN'			=> 'The number of backups that will be stored on the server.<br>0 means disabled and all backups will be stored on the server.',
	'AUTO_DB_BACKUP_ENABLE'					=> 'Enable auto database backup',
	'AUTO_DB_BACKUP_ENABLE_EXPLAIN'			=> 'Enable or disable automatic database backups',
	'AUTO_DB_BACKUP_FILETYPE'				=> 'File type',
	'AUTO_DB_BACKUP_FILETYPE_EXPLAIN'		=> 'Select the file type for the backups.',
	'AUTO_DB_BACKUP_FREQ'					=> 'Backup frequency',
	'AUTO_DB_BACKUP_FREQ_EXPLAIN'			=> 'Set backup frequency in hours.',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ'			=> 'Maintain backup freqency time',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ_EXPLAIN'	=> 'Setting this to <strong>“Yes”</strong> will mean that the backup frequency time will be maintained.<br>For example - if the time is set to 23:15 and the frequency set to 24 hours then the next backup will be at 23:15 the next day. If this is set to <strong>“No”</strong> then the next backup will be 24 hours after the backup is run.',
	'AUTO_DB_BACKUP_OPTIMIZE'				=> 'Optimize the database before performing the backup',
	'AUTO_DB_BACKUP_OPTIMIZE_EXPLAIN'		=> 'Optimize only unoptimized database tables before making the backup.',
	'AUTO_DB_BACKUP_SETTINGS'				=> 'Auto database backup settings',
	'AUTO_DB_BACKUP_SETTINGS_CHANGED'		=> 'Auto database backup settings changed.',
	'AUTO_DB_BACKUP_SETTINGS_EXPLAIN'		=> 'Here you can set up default settings for automatic database backups. Depending on your server configuration you may be able to compress the database.<br>All backups will be stored in <samp>/store/</samp> folder. You can restore backup via the <em>Restore</em> panel.',
	'AUTO_DB_BACKUP_TIME'					=> 'Next backup time',
	'AUTO_DB_BACKUP_TIME_ERROR'				=> 'The <strong>next backup time</strong> is incorrect. The time has to be defined in the future.',
	'AUTO_DB_BACKUP_TIME_EXPLAIN'			=> 'The time at which the next database backup should be made.<br><strong>Note:</strong> The date/time specified must be in the future.',

	'CLICK_SELECT'							=> 'Click in textbox to select date/time',

	'DATE_FORMAT_ERROR'						=> 'The next backup date/time format is invalid.',

	'INVALID_PHP_TIMEZONE'					=> 'The default timzone in your php.ini file is invalid.',
	'INVALID_USER_TIMEZONE'					=> 'There is a problem with your timezone setting in the UCP.',

	'NO_TIMEZONE_SET'						=> 'You do not have a timezone set in your UCP - please set this before you can continue.',

	'FILETYPE'	=> array(
		'gzip'	=> 'gzip',
		'bzip2'	=> 'bzip2',
		'text'	=> 'text',
	),

	'FILE_SIZE'	=> array(
		1 => 'bytes',
		2 => 'KB',
		3 => 'MB',
		4 => 'GB',
		5 => 'TB',
	),
));

// Date/time picker
$lang = array_merge($lang, array(
	'HOUR_TEXT'				=> 'Hour',
	'MINUTE_TEXT'			=> 'Minute',
	'NEXT_TEXT'				=> 'Next »',
	'PREV_TEXT'				=> '« Prev',
	'TIME_TEXT'				=> 'Time',

	// Translators note: retain the format of [" "] as they are creating JSON compatible arrays
	'DAY_NAMES_MIN'			=> '["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]',
	'MONTH_NAMES' 			=> '["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]',
));
