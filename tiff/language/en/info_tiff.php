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
	'GALLERY_CORE_NOT_FOUND'        => 'phpBB Gallery Core must be installed and enabled first.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'The TIFF add-on requires the Imagick PHP extension with TIFF reading and WebP writing support.',
]);
