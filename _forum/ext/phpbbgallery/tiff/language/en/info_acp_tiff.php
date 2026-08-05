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
	'ACP_GALLERY_TIFF'                      => 'TIFF images',
	'ACP_GALLERY_TIFF_EXPLAIN'              => 'Accept TIFF originals and generate private WebP medium images and thumbnails from the first frame.',
	'ACP_GALLERY_TIFF_SETTINGS'             => 'TIFF settings',
	'ACP_GALLERY_TIFF_ENABLE'               => 'Allow TIFF uploads',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN'       => 'Allows .tif and .tiff files in normal uploads, ZIP uploads and image replacements. Existing TIFF images remain accessible when disabled.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY'         => 'WebP derivative quality',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Quality from 1 to 100 used for medium images and thumbnails. TIFF originals are not converted unless Gallery limits require a transformation.',
	'ACP_GALLERY_TIFF_UPDATED'              => 'The TIFF settings were updated.',
	'GALLERY_TIFF_IMAGICK_REQUIRED'         => 'The TIFF add-on requires the Imagick PHP extension with TIFF reading and WebP writing support.',
]);
