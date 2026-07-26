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
