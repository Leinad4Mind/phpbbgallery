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
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Image revisions',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Configure optional image replacement history and rollback.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Revision settings',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Enable image revisions',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Allows image editors to replace files and restore retained versions. Each revision uses additional storage.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Revisions retained per image',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Choose from 1 to 50. Older files are deleted automatically.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'Image revision settings were updated.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Can manage Gallery image revision settings',
]);
