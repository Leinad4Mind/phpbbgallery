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
	'GALLERY_CORE_NOT_FOUND' => 'phpBB Gallery Core moet eerst geïnstalleerd en ingeschakeld zijn.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'De TIFF-add-on vereist de PHP-extensie Imagick met ondersteuning voor TIFF-lezen en WebP-schrijven.',
]);
