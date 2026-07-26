<?php
/**
 * phpBB Gallery - ACP CleanUp Extension [Dutch Translation]
 *
 * @package   phpbbgallery/acpcleanup
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
	'ACP_GALLERY_CLEANUP' => 'Galerij opschonen',

	'ACP_GALLERY_CLEANUP_EXPLAIN' => 'Hier kun je achtergebleven gegevens en bestanden verwijderen.',

	'CLEAN_AUTHORS_DONE'       => 'Afbeeldingen zonder geldige auteur zijn verwijderd.',
	'CLEAN_CHANGED'            => 'De auteur is gewijzigd in “Gast”.',
	'CLEAN_COMMENTS_DONE'      => 'Reacties zonder geldige auteur zijn verwijderd.',
	'CLEAN_ENTRIES_DONE'       => 'Bestanden zonder databasevermelding zijn verwijderd.',
	'CLEAN_GALLERY'            => 'Galerij opschonen',
	'CLEAN_GALLERY_ABORT'      => 'Het opschonen is afgebroken.',
	'CLEAN_NO_ACTION'          => 'Er is geen actie voltooid. Er is iets misgegaan.',
	'CLEAN_PERSONALS_DONE'     => 'Persoonlijke albums zonder geldige eigenaar zijn verwijderd.',
	'CLEAN_PERSONALS_BAD_DONE' => 'Persoonlijke albums van de geselecteerde gebruikers zijn verwijderd.',
	'CLEAN_PRUNE_DONE'         => 'De afbeeldingen zijn verwijderd.',
	'CLEAN_PRUNE_NO_PATTERN'   => 'Er zijn geen zoekcriteria opgegeven.',
	'CLEAN_SOURCES_DONE'       => 'Afbeeldingen zonder bestand zijn verwijderd.',

	'CONFIRM_CLEAN'               => 'Deze stap kan niet ongedaan worden gemaakt.',
	'CONFIRM_CLEAN_AUTHORS'       => 'Afbeeldingen zonder geldige auteur verwijderen?',
	'CONFIRM_CLEAN_COMMENTS'      => 'Reacties zonder geldige auteur verwijderen?',
	'CONFIRM_CLEAN_ENTRIES'       => 'Bestanden zonder databasevermelding verwijderen?',
	'CONFIRM_CLEAN_PERSONALS'     => 'Persoonlijke albums zonder geldige eigenaar verwijderen?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_PERSONALS_BAD' => 'Persoonlijke albums van de geselecteerde gebruikers verwijderen?<br /><strong>» %s</strong>',
	'CONFIRM_CLEAN_SOURCES'       => 'Afbeeldingen zonder bestand verwijderen?',
	'CONFIRM_PRUNE'               => 'Alle afbeeldingen verwijderen die aan de volgende voorwaarden voldoen?<br /><br />%s<br />',

	'PRUNE'                  => 'Selectief verwijderen',
	'PRUNE_ALBUMS'           => 'Albums opschonen',
	'PRUNE_CHECK_OPTION'     => 'Deze optie controleren bij het verwijderen van afbeeldingen.',
	'PRUNE_COMMENTS'         => 'Minder dan x reacties',
	'PRUNE_PATTERN_ALBUM_ID' => 'De afbeelding staat in een van de volgende albums:<br />&raquo; <strong>%s</strong>',
	'PRUNE_PATTERN_COMMENTS' => 'De afbeelding heeft minder dan <strong>%d</strong> reacties.',
	'PRUNE_PATTERN_RATES'    => 'De afbeelding heeft minder dan <strong>%d</strong> beoordelingen.',
	'PRUNE_PATTERN_RATE_AVG' => 'De afbeelding heeft een gemiddelde beoordeling lager dan <strong>%s</strong>.',
	'PRUNE_PATTERN_TIME'     => 'De afbeelding is vóór “<strong>%s</strong>” geüpload.',
	'PRUNE_PATTERN_USER_ID'  => 'De afbeelding is geüpload door een van de volgende gebruikers:<br />&raquo; <strong>%s</strong>',
	'PRUNE_RATINGS'          => 'Minder dan x beoordelingen',
	'PRUNE_RATING_AVG'       => 'Gemiddelde beoordeling lager dan',
	'PRUNE_RATING_AVG_EXP'   => 'Alleen afbeeldingen verwijderen met een gemiddelde beoordeling lager dan “<samp>x.yz</samp>”.',
	'PRUNE_TIME'             => 'Geüpload vóór',
	'PRUNE_TIME_EXP'         => 'Alleen afbeeldingen verwijderen die vóór “<samp>JJJJ-MM-DD</samp>” zijn geüpload.',
	'PRUNE_USERNAME'         => 'Geüpload door',
	'PRUNE_USERNAME_EXP'     => 'Alleen afbeeldingen van bepaalde gebruikers verwijderen. Schakel het selectievakje naast het gebruikersnaamveld in om afbeeldingen van gasten mee te nemen.',

	// Logboek
	'LOG_CLEANUP_DELETE_FILES'             => '%s afbeeldingen zonder databasevermelding zijn verwijderd.',
	'LOG_CLEANUP_DELETE_ENTRIES'           => '%s afbeeldingen zonder bestand zijn verwijderd.',
	'LOG_CLEANUP_DELETE_NO_AUTHOR'         => '%s afbeeldingen zonder geldige auteur zijn verwijderd.',
	'LOG_CLEANUP_COMMENT_DELETE_NO_AUTHOR' => '%s reacties zonder geldige auteur zijn verwijderd.',

	'MOVE_TO_IMPORT'       => 'Afbeeldingen naar de importmap verplaatsen',
	'MOVE_TO_USER'         => 'Aan gebruiker toewijzen',
	'MOVE_TO_USER_EXP'     => 'Afbeeldingen en reacties worden aan de opgegeven gebruiker toegewezen. Als je niemand selecteert, wordt de anonieme gebruiker gebruikt.',
	'CLEAN_USER_NOT_FOUND' => 'De geselecteerde gebruiker bestaat niet.',

	'GALLERY_CORE_NOT_FOUND'   => 'De phpBB Gallery Core-extensie moet eerst worden geïnstalleerd en ingeschakeld.',
	'EXTENSION_ENABLE_SUCCESS' => 'De extensie is ingeschakeld.',
]);
