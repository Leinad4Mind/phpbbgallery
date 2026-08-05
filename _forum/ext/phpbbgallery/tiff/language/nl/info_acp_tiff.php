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
	'ACP_GALLERY_TIFF' => 'TIFF-afbeeldingen',
	'ACP_GALLERY_TIFF_EXPLAIN' => 'Accepteert TIFF-originelen en maakt privé WebP-middelgrote afbeeldingen en miniaturen van het eerste frame.',
	'ACP_GALLERY_TIFF_SETTINGS' => 'TIFF-instellingen',
	'ACP_GALLERY_TIFF_ENABLE' => 'TIFF-uploads toestaan',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN' => 'Staat .tif- en .tiff-bestanden toe bij normale uploads, ZIP-uploads en vervangingen. Bestaande TIFF-afbeeldingen blijven toegankelijk als dit is uitgeschakeld.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY' => 'Kwaliteit van WebP-afgeleiden',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Kwaliteit van 1 tot 100 voor middelgrote afbeeldingen en miniaturen. TIFF-originelen worden alleen aangepast als Gallery-limieten dit vereisen.',
	'ACP_GALLERY_TIFF_UPDATED' => 'De TIFF-instellingen zijn bijgewerkt.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'De TIFF-add-on vereist de PHP-extensie Imagick met ondersteuning voor TIFF-lezen en WebP-schrijven.',
]);
