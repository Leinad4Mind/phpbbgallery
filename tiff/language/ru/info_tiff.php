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
	'GALLERY_CORE_NOT_FOUND' => 'Сначала необходимо установить и включить phpBB Gallery Core.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'Для дополнения TIFF требуется расширение PHP Imagick с поддержкой чтения TIFF и записи WebP.',
]);
