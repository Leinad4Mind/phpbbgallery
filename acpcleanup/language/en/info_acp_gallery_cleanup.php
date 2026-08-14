<?php
/**
 * phpBB Gallery - ACP CleanUp Extension [German Translation]
 *
 * @package   phpbbgallery/acpcleanup
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
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

$lang = array_merge($lang, [
	'ACP_GALLERY_CLEANUP' => 'Cleanup gallery',

	'ACP_GALLERY_CLEANUP_EXPLAIN' => 'Here you can delete some remains.',

	'CLEAN_AUTHORS_DONE'       => 'Images without valid author deleted.',
	'CLEAN_CHANGED'            => 'Author changed to “Guest“.',
	'CLEAN_COMMENTS_DONE'      => 'Comments without valid author deleted.',
	'CLEAN_ENTRIES_DONE'       => 'Files without database-entry deleted.',
	'CLEAN_GALLERY'            => 'Clean gallery',
	'CLEAN_GALLERY_ABORT'      => 'Cleanup abort!',
	'CLEAN_NO_ACTION'          => 'No action completed. Something went wrong!',
	'CLEAN_PERSONALS_DONE'     => 'Personal albums without valid owner deleted.',
	'CLEAN_PERSONALS_BAD_DONE' => 'Personal albums from selected users deleted.',
	'CLEAN_PRUNE_DONE'         => 'Successfully pruned images.',
	'CLEAN_PRUNE_NO_PATTERN'   => 'No search pattern.',
	'CLEAN_SOURCES_DONE'       => 'Images without file deleted.',

	'SOURCE_CHECK_PROGRESS' => 'Checking Gallery source files',
	'SOURCE_CHECK_COMPLETE' => 'Source-file check completed',
	'SOURCE_CHECK_RESULT' => 'Checked: %1$d; missing source files: %2$d.',
	'SOURCE_CHECK_RUN' => 'Check source files again',
	'MISSING_SOURCE_DIAGNOSTIC_EXPLAIN' => 'This diagnostic checks the active storage provider in resumable batches of 25. Missing medium or mini files do not make a database record invalid because those derivatives can be regenerated from the source.',
	'MISSING_SOURCE_SUMMARY' => '%1$d records have no source file in the active %2$s provider.',
	'MISSING_SOURCE_CONTEXT' => 'Album and author',
	'MISSING_SOURCE_EXPECTED_KEY' => 'Expected source object',
	'MISSING_SOURCE_DERIVATIVES' => 'Existing derivatives',
	'MISSING_SOURCE_MEDIUM' => 'Medium',
	'MISSING_SOURCE_MINI' => 'Mini',
	'MISSING_SOURCE_RESTORE_EXPLAIN' => 'Restore recoverable originals to the exact provider and source key shown above, then run the check again. Select and delete only records whose original files cannot be recovered; deletion is confirmed and uses the Gallery domain cleanup so related counters and data remain consistent.',
	'MISSING_SOURCE_STATUS_UNAPPROVED' => 'Awaiting approval',
	'MISSING_SOURCE_STATUS_APPROVED' => 'Approved',
	'MISSING_SOURCE_STATUS_LOCKED' => 'Locked',
	'MISSING_SOURCE_STATUS_ORPHAN' => 'Unfinished upload',
	'MISSING_SOURCE_STATUS_DELETE_REQUESTED' => 'Deletion requested',
	'MISSING_SOURCE_STATUS_UNKNOWN' => 'Unknown',

	'CONFIRM_CLEAN'               => 'This step can not be undone!',
	'CONFIRM_CLEAN_AUTHORS'       => 'Delete images without valid author?',
	'CONFIRM_CLEAN_COMMENTS'      => 'Delete comments without valid author?',
	'CONFIRM_CLEAN_ENTRIES'       => 'Delete files without database-entry?',
	'CONFIRM_CLEAN_PERSONALS'     => 'Delete personal albums without valid owner?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_PERSONALS_BAD' => 'Delete personal albums from selected users?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_SOURCES'       => 'Delete images without file?',
	'CONFIRM_PRUNE'               => 'Delete all images, that have the following conditions:<br /><br />%s<br />',

	'PRUNE'                  => 'Prune',
	'PRUNE_ALBUMS'           => 'Prune albums',
	'PRUNE_CHECK_OPTION'     => 'Check this option, while pruning images.',
	'PRUNE_COMMENTS'         => 'Less than x comments',
	'PRUNE_PATTERN_ALBUM_ID' => 'The image is in one of the following albums:<br />&raquo; <strong>%s</strong>',
	'PRUNE_PATTERN_COMMENTS' => 'The image has less than <strong>%d</strong> comments.',
	'PRUNE_PATTERN_RATES'    => 'The image has less than <strong>%d</strong> ratings.',
	'PRUNE_PATTERN_RATE_AVG' => 'The image has a rating average, lower than <strong>%s</strong>.',
	'PRUNE_PATTERN_TIME'     => 'The image was uploaded before “<strong>%s</strong>“.',
	'PRUNE_PATTERN_USER_ID'  => 'The image was uploaded by one of the following users:<br />&raquo; <strong>%s</strong>',
	'PRUNE_RATINGS'          => 'Less than x ratings',
	'PRUNE_RATING_AVG'       => 'Average rating lower than',
	'PRUNE_RATING_AVG_EXP'   => 'Only prune images, with an average rating lower than “<samp>x.yz</samp>“.',
	'PRUNE_TIME'             => 'Uploaded before',
	'PRUNE_TIME_EXP'         => 'Only prune images, that where uploaded before “<samp>YYYY-MM-DD</samp>“.',
	'PRUNE_USERNAME'         => 'Uploaded by',
	'PRUNE_USERNAME_EXP'     => 'Only prune images from certain users. To prune images from “guests“ select the checkbox beyond the username-box.',

	//Log
	'LOG_CLEANUP_DELETE_FILES'             => '%s images without DB entries were deleted.',
	'LOG_CLEANUP_DELETE_ENTRIES'           => '%s images without files were deleted.',
	'LOG_CLEANUP_DELETE_NO_AUTHOR'         => '%s images without valid author were deleted.',
	'LOG_CLEANUP_COMMENT_DELETE_NO_AUTHOR' => '%s comments without valid author were deleted.',

	'MOVE_TO_IMPORT'       => 'Move images to Import directory',
	'MOVE_TO_USER'         => 'Move to user',
	'MOVE_TO_USER_EXP'     => 'Images and comments will be moved as those of user you have defined. If none is selected - Anonymous will be used.',
	'CLEAN_USER_NOT_FOUND' => 'The user you selected does not exists!',

	'GALLERY_CORE_NOT_FOUND'   => 'phpBB Gallery Core extension must be installed and enabled first.',
	'EXTENSION_ENABLE_SUCCESS' => 'The extension has been enabled successfully.',

	'GALLERY_LEGACY_BBCODE_MIGRATE'         => 'Migrate legacy Gallery BBCodes',
	'GALLERY_LEGACY_BBCODE_MIGRATE_EXPLAIN' => 'Searches posts, private messages and signatures for the hidden [album] alias. After confirmation, each run reparses up to %1$d records as %2$s and keeps the phpBB BBCode metadata consistent. Repeat the action until no records remain.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM' => 'Convert the next batch from [album] to %2$s? There are currently %1$d records remaining.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_NONE'    => 'There are no legacy [album] records remaining.',
	'GALLERY_LEGACY_BBCODE_MIGRATE_RESULT'  => '%1$d records were converted. %2$d records could not be converted. %3$d records remain.',
]);
