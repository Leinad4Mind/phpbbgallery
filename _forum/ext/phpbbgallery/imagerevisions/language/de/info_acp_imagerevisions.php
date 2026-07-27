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
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Bildversionen',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Optionalen Verlauf für Bildersetzung und Wiederherstellung konfigurieren.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Versionseinstellungen',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Bildversionen aktivieren',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Ermöglicht Bildbearbeitern, Dateien zu ersetzen und gespeicherte Versionen wiederherzustellen. Jede Version benötigt zusätzlichen Speicherplatz.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Gespeicherte Versionen je Bild',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Wähle einen Wert von 1 bis 50. Ältere Dateien werden automatisch gelöscht.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'Die Einstellungen für Bildversionen wurden aktualisiert.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Darf Einstellungen für Bildversionen verwalten',
]);
