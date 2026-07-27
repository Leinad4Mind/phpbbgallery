<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'REPLACE_IMAGE'                => 'Replace image file',
	'REPLACE_IMAGE_EXPLAIN'        => 'Select a new image file. The image ID, description, comments, ratings and view count are preserved.',
	'IMAGE_REVISIONS'              => 'Previous image files',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Retained files can be previewed and restored. Restoring a file keeps the current file in the history.',
	'RESTORE_REVISION'             => 'Restore this version',
	'IMAGE_REPLACE_FAILED'         => 'The replacement file could not be applied safely.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'This image revision is no longer available.',
	'IMAGE_REVISION_RESTORED'      => 'The image revision was restored successfully.',
]);
