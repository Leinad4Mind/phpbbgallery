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
	'GALLERY_CORE_NOT_FOUND' => 'phpBB Gallery Core deve essere prima installato e attivato.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'L’add-on TIFF richiede l’estensione PHP Imagick con lettura TIFF e scrittura WebP.',
]);
