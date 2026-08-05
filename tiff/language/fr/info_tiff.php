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
	'GALLERY_CORE_NOT_FOUND' => 'phpBB Gallery Core doit d’abord être installé et activé.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'L’add-on TIFF nécessite l’extension PHP Imagick avec lecture TIFF et écriture WebP.',
]);
