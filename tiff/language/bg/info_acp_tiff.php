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
	'ACP_GALLERY_TIFF' => 'TIFF изображения',
	'ACP_GALLERY_TIFF_EXPLAIN' => 'Приема TIFF оригинали и създава частни WebP средни изображения и миниатюри от първия frame.',
	'ACP_GALLERY_TIFF_SETTINGS' => 'Настройки за TIFF',
	'ACP_GALLERY_TIFF_ENABLE' => 'Разреши качвания на TIFF',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN' => 'Разрешава .tif и .tiff файлове при нормални и ZIP качвания и замяна на изображения. Съществуващите TIFF изображения остават достъпни при изключване.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY' => 'Качество на WebP производните',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Качество от 1 до 100 за средни изображения и миниатюри. TIFF оригиналите се преобразуват само когато ограниченията на Галерията го изискват.',
	'ACP_GALLERY_TIFF_UPDATED' => 'Настройките за TIFF бяха обновени.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'Добавката TIFF изисква PHP разширението Imagick с поддръжка за четене на TIFF и запис на WebP.',
]);
