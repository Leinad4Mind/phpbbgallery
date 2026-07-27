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
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Kan instellingen voor afbeeldingsrevisies beheren',
]);
