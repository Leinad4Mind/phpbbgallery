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
	'REPLACE_IMAGE'                => 'Afbeeldingsbestand vervangen',
	'REPLACE_IMAGE_EXPLAIN'        => 'Selecteer een nieuw bestand. De afbeeldings-ID, beschrijving, reacties, beoordelingen en weergaveteller blijven behouden.',
	'IMAGE_REVISIONS'              => 'Eerdere afbeeldingsbestanden',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Bewaarde bestanden kunnen worden bekeken en hersteld. Bij herstel blijft het huidige bestand in de geschiedenis bewaard.',
	'RESTORE_REVISION'             => 'Deze versie herstellen',
	'IMAGE_REPLACE_FAILED'         => 'Het vervangende bestand kon niet veilig worden toegepast.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Deze afbeeldingsrevisie is niet meer beschikbaar.',
	'IMAGE_REVISION_RESTORED'      => 'De afbeeldingsrevisie is succesvol hersteld.',
]);
