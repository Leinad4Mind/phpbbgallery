<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

/**
* @ignore
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
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core is missing! Please download it and install it before this extension.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension was enabled successfully.',

	'EXPORT_SELECTION'				=> 'What to export',
	'EXPORT_ALBUMS'					=> 'Albums',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Pick one or more albums. Hold Ctrl to select several.',
	'EXPORT_ALL_ALBUMS'				=> 'Export the whole gallery, ignoring the selection above',
	'EXPORT_DELIVERY'				=> 'Where the archive goes',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'An archive left on the server is written to %s and is never removed automatically, so you can collect it over FTP whenever you like.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Offer it as a download',
	'EXPORT_DELIVERY_SERVER'		=> 'Leave it on the server',
	'EXPORT_LIMITS'					=> 'Limits',
	'EXPORT_LIMITS_EXPLAIN'			=> 'At most %1$d images and %2$s per export, written %3$d images at a time.',
	'EXPORT_START'					=> 'Start export',
	'EXPORT_CONTINUE'				=> 'Continue',
	'EXPORT_DOWNLOAD'				=> 'Download',

	'EXPORT_STARTED'				=> [
		1	=> 'The export of %d image has started.',
		2	=> 'The export of %d images has started.',
	],
	'EXPORT_PROGRESS'				=> 'Exported %1$d of %2$d images…',
	'EXPORT_FINISHED'				=> [
		1	=> 'The export finished with %d image.',
		2	=> 'The export finished with %d images.',
	],

	'EXPORT_JOBS'					=> 'Exports',
	'EXPORT_NO_JOBS'				=> 'There are no exports yet.',
	'EXPORT_JOB_ARCHIVE'			=> 'Archive',
	'EXPORT_JOB_CREATED'			=> 'Started',
	'EXPORT_JOB_PROGRESS'			=> 'Progress',
	'EXPORT_JOB_SIZE'				=> 'Size',
	'EXPORT_JOB_ACTION'				=> 'Action',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> '%d image could not be added.',
		2	=> '%d images could not be added.',
	],
	'EXPORT_JOB_DELETED'			=> 'The export was deleted.',
	'EXPORT_JOB_NOT_FOUND'			=> 'That export does not exist, or it does not belong to you.',
	'EXPORT_STATUS_READY'			=> 'Ready',
	'EXPORT_STATUS_RUNNING'			=> 'Running',

	'EXPORT_UCP_EXPLAIN'			=> 'Here you can download the images you uploaded, named the way the gallery shows them instead of the way they are stored on disk. Up to %d images per export.',
	'EXPORT_UCP_DISABLED'			=> 'The board administrator has turned off exporting your own images.',

	'EXPORT_NO_IMAGES'				=> 'There are no images to export.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'An export may cover at most %d images. Please export fewer albums at a time.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'An export may be at most %s. Please export fewer albums at a time.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'There is not enough free space on the server for this export.',
	'EXPORT_ARCHIVE_FAILED'			=> 'The archive could not be written.',
	'EXPORT_ARCHIVE_MISSING'		=> 'The archive of this export is no longer on the server.',
	'EXPORT_STATE_FAILED'			=> 'The state of this export could not be saved. Please check that the export directory is writable.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Image %1$d was skipped: the file “%2$s” is not on the server.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Image %1$d was skipped: the file “%2$s” could not be read.',
	'EXPORT_ERROR_ARCHIVE'			=> 'The archive “%s” could not be written.',
]);
