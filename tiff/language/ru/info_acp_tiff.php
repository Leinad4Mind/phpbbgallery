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
	'ACP_GALLERY_TIFF' => 'Изображения TIFF',
	'ACP_GALLERY_TIFF_EXPLAIN' => 'Принимает оригиналы TIFF и создаёт закрытые средние изображения и миниатюры WebP из первого frame.',
	'ACP_GALLERY_TIFF_SETTINGS' => 'Настройки TIFF',
	'ACP_GALLERY_TIFF_ENABLE' => 'Разрешить загрузку TIFF',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN' => 'Разрешает файлы .tif и .tiff при обычной и ZIP-загрузке и замене изображений. Существующие TIFF остаются доступны после отключения.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY' => 'Качество производных WebP',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Качество от 1 до 100 для средних изображений и миниатюр. Оригиналы TIFF преобразуются только при необходимости соблюдения ограничений Галереи.',
	'ACP_GALLERY_TIFF_UPDATED' => 'Настройки TIFF обновлены.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'Для дополнения TIFF требуется расширение PHP Imagick с поддержкой чтения TIFF и записи WebP.',
]);
