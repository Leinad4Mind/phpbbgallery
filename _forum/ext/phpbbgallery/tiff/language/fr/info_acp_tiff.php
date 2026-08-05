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
	'ACP_GALLERY_TIFF' => 'Images TIFF',
	'ACP_GALLERY_TIFF_EXPLAIN' => 'Accepte les originaux TIFF et génère des images moyennes et miniatures WebP privées depuis le premier frame.',
	'ACP_GALLERY_TIFF_SETTINGS' => 'Paramètres TIFF',
	'ACP_GALLERY_TIFF_ENABLE' => 'Autoriser les envois TIFF',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN' => 'Autorise les fichiers .tif et .tiff dans les envois normaux, ZIP et remplacements. Les images TIFF existantes restent accessibles après désactivation.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY' => 'Qualité des dérivés WebP',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Qualité de 1 à 100 pour les images moyennes et miniatures. Les originaux TIFF ne sont transformés que si les limites de la Galerie l’exigent.',
	'ACP_GALLERY_TIFF_UPDATED' => 'Les paramètres TIFF ont été mis à jour.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'L’add-on TIFF nécessite l’extension PHP Imagick avec lecture TIFF et écriture WebP.',
]);
