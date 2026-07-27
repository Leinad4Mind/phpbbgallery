<?php
/**
 * phpBB Gallery - ACP Import Extension [Dutch Translation]
 *
 * @package   phpbbgallery/acpimport
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_IMPORT_ALBUMS'         => 'Afbeeldingen importeren',
	'ACP_IMPORT_ALBUMS_EXPLAIN' => 'Hier kun je meerdere afbeeldingen uit het bestandssysteem importeren. Pas vóór het importeren handmatig het formaat aan.',

	'IMPORT_ARCHIVES'            => 'ZIP-archieven',
	'IMPORT_ARCHIVES_SELECT'     => 'Kies de archieven die je wilt uitpakken. De afbeeldingen komen in de importmap terecht, waar je daarna kunt kiezen welke je wilt importeren. Uitgepakte archieven worden verwijderd.',
	'IMPORT_EXTRACT'             => 'Uitpakken',
	'IMPORT_NO_ARCHIVES'         => 'Er staan geen ZIP-archieven in de importmap.',
	'IMPORT_ZIP_ALL_EXTRACTED'   => 'Er zijn %1$d afbeeldingen uit %2$d archieven uitgepakt. Kies hieronder welke je wilt importeren.',
	'IMPORT_ZIP_EXTRACTED'       => '%1$d afbeeldingen uitgepakt uit “%2$s”.',
	'IMPORT_ZIP_FAILED'          => 'Het archief “%s” kon niet worden uitgepakt.',
	'IMPORT_ZIP_MAX_IMAGES'      => 'Afbeeldingen per archief',
	'IMPORT_ZIP_MAX_IMAGES_EXPLAIN' => 'Hoeveel afbeeldingen één archief mag opleveren. Een archief wordt nooit verder dan 1000 items gelezen, dus dat is ook de hoogste zinvolle waarde.',
	'IMPORT_ZIP_SETTINGS'        => 'ZIP-archieven',
	'IMPORT_ZIP_SETTINGS_SAVED'  => 'De archiefinstellingen zijn opgeslagen.',
	'IMPORT_ALBUM'               => 'Doelalbum:',
	'IMPORT_DEBUG_MES'           => '%1$s afbeeldingen zijn geïmporteerd. Er zijn nog %2$s afbeeldingen over.',
	'IMPORT_DIR_EMPTY'           => 'De map %s is leeg. Upload de afbeeldingen voordat je ze importeert.',
	'IMPORT_FINISHED'            => 'Alle %1$s afbeeldingen zijn geïmporteerd.',
	'IMPORT_FINISHED_ERRORS'     => '%1$s afbeeldingen zijn geïmporteerd, maar de volgende fouten zijn opgetreden:<br /><br />',
	'IMPORT_MISSING_ALBUM'       => 'Selecteer een album waarin de afbeeldingen moeten worden geïmporteerd.',
	'IMPORT_SELECT'              => 'Selecteer de afbeeldingen die je wilt importeren. Geïmporteerde afbeeldingen worden verwijderd; alle andere afbeeldingen blijven beschikbaar.',
	'IMPORT_SCHEMA_CREATED'      => 'De importstatus is aangemaakt. Wacht terwijl de afbeeldingen worden geïmporteerd.',
	'IMPORT_INVALID_IMAGE'       => 'Het geselecteerde bestand “%s” is geen toegestane afbeelding uit de importmap.',
	'IMPORT_SCHEMA_WRITE_FAILED' => 'De importstatus kon niet veilig worden opgeslagen.',
	'IMPORT_TOO_MANY_IMAGES'     => 'Je kunt maximaal %d afbeeldingen tegelijk importeren.',
	'IMPORT_UNREADABLE_FILES'    => '%d bestanden met onleesbare namen zijn genegeerd.',
	'IMPORT_USER'                => 'Geüpload door',
	'IMPORT_USER_EXP'            => 'Hier kun je de afbeeldingen aan een andere gebruiker toewijzen.',
	'IMPORT_USERS_PEGA'          => 'Uploaden naar de persoonlijke galerij van gebruikers.',

	'MISSING_IMPORT_SCHEMA' => 'De opgegeven importstatus (%s) is niet gevonden.',

	'NO_FILE_SELECTED' => 'Selecteer ten minste één bestand.',

	'GALLERY_CORE_NOT_FOUND'   => 'De phpBB Gallery Core-extensie moet eerst worden geïnstalleerd en ingeschakeld.',
	'EXTENSION_ENABLE_SUCCESS' => 'De extensie is ingeschakeld.',
]);
