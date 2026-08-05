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
	'ACP_GALLERY_TIFF' => 'Immagini TIFF',
	'ACP_GALLERY_TIFF_EXPLAIN' => 'Accetta originali TIFF e genera immagini medie e miniature WebP private dal primo frame.',
	'ACP_GALLERY_TIFF_SETTINGS' => 'Impostazioni TIFF',
	'ACP_GALLERY_TIFF_ENABLE' => 'Consenti caricamenti TIFF',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN' => 'Consente file .tif e .tiff nei caricamenti normali, ZIP e sostituzioni. Le immagini TIFF esistenti restano accessibili quando disattivato.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY' => 'Qualità dei derivati WebP',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Qualità da 1 a 100 per immagini medie e miniature. Gli originali TIFF vengono trasformati solo quando richiesto dai limiti della Galleria.',
	'ACP_GALLERY_TIFF_UPDATED' => 'Le impostazioni TIFF sono state aggiornate.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'L’add-on TIFF richiede l’estensione PHP Imagick con lettura TIFF e scrittura WebP.',
]);
