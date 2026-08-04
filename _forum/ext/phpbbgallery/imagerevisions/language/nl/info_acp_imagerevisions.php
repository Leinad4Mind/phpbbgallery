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
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Afbeeldingsrevisies',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Configureer de optionele geschiedenis voor het vervangen en herstellen van afbeeldingen.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Revisie-instellingen',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Afbeeldingsrevisies inschakelen',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Staat afbeeldingsbewerkers toe bestanden te vervangen en bewaarde versies te herstellen. Elke revisie gebruikt extra opslagruimte.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Bewaarde revisies per afbeelding',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Kies van 1 tot 50. Oudere bestanden worden automatisch verwijderd.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'De instellingen voor afbeeldingsrevisies zijn bijgewerkt.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Afbeeldingsrevisies voor dit album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Elke instelling kan de effectieve waarde van het dichtstbijzijnde bovenliggende album of de algemene standaard overnemen.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Overnemen',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Effectieve instelling: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Effectieve waarde: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Revisies per album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Dit alleen-lezen overzicht volgt de albumhiërarchie. Gebruik Wijzig om een album of subalbum aan te passen.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Album',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Overgenomen',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Directe instelling',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Ingesteld op %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'Er zijn geen openbare Gallery-albums.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Kan instellingen voor afbeeldingsrevisies beheren',
]);
