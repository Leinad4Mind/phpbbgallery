<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [German [de]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core fehlt! Bitte lade es herunter und installiere es vor dieser Erweiterung.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'Die Erweiterung wurde erfolgreich aktiviert.',

	'EXPORT_SELECTION'				=> 'Was exportiert wird',
	'EXPORT_ALBUMS'					=> 'Alben',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Wähle ein oder mehrere Alben aus. Halte die Strg-Taste gedrückt, um mehrere auszuwählen.',
	'EXPORT_ALL_ALBUMS'				=> 'Die gesamte Galerie exportieren und die Auswahl oben ignorieren',
	'EXPORT_DELIVERY'				=> 'Ziel des Archivs',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Ein auf dem Server belassenes Archiv wird nach %s geschrieben und nie automatisch entfernt, sodass du es jederzeit per FTP abholen kannst.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Zum Herunterladen anbieten',
	'EXPORT_DELIVERY_SERVER'		=> 'Auf dem Server belassen',
	'EXPORT_LIMITS'					=> 'Grenzwerte',
	'EXPORT_LIMITS_EXPLAIN'			=> 'Höchstens %1$d Bilder und %2$s pro Export, dabei werden %3$d Bilder auf einmal geschrieben.',
	'EXPORT_SETTINGS'				=> 'Exporteinstellungen',
	'EXPORT_MAX_IMAGES'				=> 'Maximale Bilder pro Export',
	'EXPORT_MAX_IMAGES_EXPLAIN'		=> 'Maximal zulässige Anzahl von Bildern in einem Export. Die Sicherheitsgrenze ist %d.',
	'EXPORT_MAX_SIZE_MIB'			=> 'Maximale Größe pro Export (MiB)',
	'EXPORT_MAX_SIZE_MIB_EXPLAIN'	=> 'Maximale Gesamtgröße der Originaldateien. Die Sicherheitsgrenze ist %d MiB.',
	'EXPORT_BATCH_SIZE'				=> 'Bilder pro Stapel',
	'EXPORT_BATCH_SIZE_EXPLAIN'		=> 'Anzahl der pro Anfrage geschriebenen Bilder. Kleinere Werte verringern Speicherbedarf und Timeout-Risiko. Die Grenze ist %d.',
	'EXPORT_SETTINGS_SAVED'			=> 'Die Exporteinstellungen wurden gespeichert.',
	'EXPORT_START'					=> 'Export starten',
	'EXPORT_CONTINUE'				=> 'Fortsetzen',
	'EXPORT_DOWNLOAD'				=> 'Herunterladen',

	'EXPORT_STARTED'				=> [
		1	=> 'Der Export von %d Bild wurde gestartet.',
		2	=> 'Der Export von %d Bildern wurde gestartet.',
	],
	'EXPORT_PROGRESS'				=> '%1$d von %2$d Bildern exportiert…',
	'EXPORT_FINISHED'				=> [
		1	=> 'Der Export wurde mit %d Bild abgeschlossen.',
		2	=> 'Der Export wurde mit %d Bildern abgeschlossen.',
	],

	'EXPORT_JOBS'					=> 'Exporte',
	'EXPORT_NO_JOBS'				=> 'Es gibt noch keine Exporte.',
	'EXPORT_JOB_ARCHIVE'			=> 'Archiv',
	'EXPORT_JOB_CREATED'			=> 'Gestartet',
	'EXPORT_JOB_PROGRESS'			=> 'Fortschritt',
	'EXPORT_JOB_SIZE'				=> 'Größe',
	'EXPORT_JOB_ACTION'				=> 'Aktion',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> '%d Bild konnte nicht hinzugefügt werden.',
		2	=> '%d Bilder konnten nicht hinzugefügt werden.',
	],
	'EXPORT_JOB_DELETED'			=> 'Der Export wurde gelöscht.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Dieser Export existiert nicht oder gehört dir nicht.',
	'EXPORT_STATUS_READY'			=> 'Fertig',
	'EXPORT_STATUS_RUNNING'			=> 'Läuft',

	'EXPORT_UCP_EXPLAIN'			=> 'Hier kannst du die von dir hochgeladenen Bilder herunterladen, benannt so, wie die Galerie sie anzeigt, und nicht so, wie sie auf der Festplatte gespeichert sind. Bis zu %d Bilder pro Export.',
	'EXPORT_UCP_DISABLED'			=> 'Der Administrator hat den Export eigener Bilder deaktiviert.',

	'EXPORT_NO_IMAGES'				=> 'Es gibt keine Bilder zum Exportieren.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Ein Export darf höchstens %d Bilder umfassen. Bitte exportiere weniger Alben auf einmal.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Ein Export darf höchstens %s groß sein. Bitte exportiere weniger Alben auf einmal.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'Auf dem Server ist nicht genügend freier Speicherplatz für diesen Export vorhanden.',
	'EXPORT_ARCHIVE_FAILED'			=> 'Das Archiv konnte nicht geschrieben werden.',
	'EXPORT_ARCHIVE_MISSING'		=> 'Das Archiv dieses Exports liegt nicht mehr auf dem Server.',
	'EXPORT_STATE_FAILED'			=> 'Der Status dieses Exports konnte nicht gespeichert werden. Bitte prüfe, ob das Export-Verzeichnis beschreibbar ist.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Bild %1$d wurde übersprungen: die Datei „%2$s“ liegt nicht auf dem Server.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Bild %1$d wurde übersprungen: die Datei „%2$s“ konnte nicht gelesen werden.',
	'EXPORT_ERROR_ARCHIVE'			=> 'Das Archiv „%s“ konnte nicht geschrieben werden.',
]);
