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
	'GALLERY_CORE_NOT_FOUND' => 'phpBB Gallery Core трябва първо да бъде инсталиран и активиран.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'Добавката TIFF изисква PHP разширението Imagick с поддръжка за четене на TIFF и запис на WebP.',
]);
