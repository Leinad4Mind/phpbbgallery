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
	'GALLERY_CORE_NOT_FOUND' => 'phpBB Gallery Core debe estar instalado y activado primero.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'El complemento TIFF requiere la extensión PHP Imagick con lectura TIFF y escritura WebP.',
]);
