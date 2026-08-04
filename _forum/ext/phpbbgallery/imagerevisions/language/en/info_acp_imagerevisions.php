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
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Image revisions for this album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Each setting can inherit the effective value of the nearest parent album or the global default.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Inherit',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Effective setting: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Effective value: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Revisions by album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'This read-only overview follows the Gallery album hierarchy. Use Edit to change an album or subalbum.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Album',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Inherited',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Direct setting',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Set to %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'There are no public Gallery albums.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Can manage Gallery image revision settings',
]);
