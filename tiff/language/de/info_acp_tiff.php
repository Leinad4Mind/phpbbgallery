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
	'ACP_GALLERY_TIFF' => 'TIFF-Bilder',
	'ACP_GALLERY_TIFF_EXPLAIN' => 'Akzeptiert TIFF-Originale und erzeugt private WebP-Mittelbilder und Vorschaubilder aus dem ersten Frame.',
	'ACP_GALLERY_TIFF_SETTINGS' => 'TIFF-Einstellungen',
	'ACP_GALLERY_TIFF_ENABLE' => 'TIFF-Uploads erlauben',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN' => 'Erlaubt .tif- und .tiff-Dateien bei normalen Uploads, ZIP-Uploads und Bildersetzungen. Vorhandene TIFF-Bilder bleiben bei Deaktivierung erreichbar.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY' => 'Qualität der WebP-Ableitungen',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Qualität von 1 bis 100 für Mittelbilder und Vorschaubilder. TIFF-Originale werden nur umgewandelt, wenn Gallery-Grenzwerte dies erfordern.',
	'ACP_GALLERY_TIFF_UPDATED' => 'Die TIFF-Einstellungen wurden aktualisiert.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'Das TIFF-Add-on benötigt die PHP-Erweiterung Imagick mit Unterstützung zum Lesen von TIFF und Schreiben von WebP.',
]);
