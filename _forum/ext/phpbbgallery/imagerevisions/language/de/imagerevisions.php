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
	'REPLACE_IMAGE'                => 'Bilddatei ersetzen',
	'REPLACE_IMAGE_EXPLAIN'        => 'Wähle eine neue Bilddatei. Bild-ID, Beschreibung, Kommentare, Bewertungen und Aufrufzahl bleiben erhalten.',
	'IMAGE_REVISIONS'              => 'Frühere Bilddateien',
	'IMAGE_REVISIONS_EXPLAIN'      => 'Gespeicherte Dateien können angezeigt und wiederhergestellt werden. Beim Wiederherstellen bleibt die aktuelle Datei im Verlauf erhalten.',
	'RESTORE_REVISION'             => 'Diese Version wiederherstellen',
	'IMAGE_REPLACE_FAILED'         => 'Die Ersatzdatei konnte nicht sicher angewendet werden.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Diese Bildversion ist nicht mehr verfügbar.',
	'IMAGE_REVISION_RESTORED'      => 'Die Bildversion wurde erfolgreich wiederhergestellt.',
]);
