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
	'GALLERY_CORE_NOT_FOUND' => 'phpBB Gallery Core muss zuerst installiert und aktiviert werden.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'Das TIFF-Add-on benötigt die PHP-Erweiterung Imagick mit Unterstützung zum Lesen von TIFF und Schreiben von WebP.',
]);
