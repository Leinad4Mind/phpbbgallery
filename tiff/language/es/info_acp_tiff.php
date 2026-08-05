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
	'ACP_GALLERY_TIFF' => 'Imágenes TIFF',
	'ACP_GALLERY_TIFF_EXPLAIN' => 'Acepta originales TIFF y genera imágenes medianas y miniaturas WebP privadas a partir del primer frame.',
	'ACP_GALLERY_TIFF_SETTINGS' => 'Ajustes TIFF',
	'ACP_GALLERY_TIFF_ENABLE' => 'Permitir cargas TIFF',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN' => 'Permite archivos .tif y .tiff en cargas normales, ZIP y sustituciones. Las imágenes TIFF existentes siguen accesibles al desactivarlo.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY' => 'Calidad de derivados WebP',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Calidad de 1 a 100 para imágenes medianas y miniaturas. Los originales TIFF solo se transforman cuando lo exigen los límites de la Galería.',
	'ACP_GALLERY_TIFF_UPDATED' => 'Los ajustes TIFF se actualizaron.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'El complemento TIFF requiere la extensión PHP Imagick con lectura TIFF y escritura WebP.',
]);
