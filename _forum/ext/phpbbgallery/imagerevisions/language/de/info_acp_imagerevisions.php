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
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Bildversionen für dieses Album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Jede Einstellung kann den wirksamen Wert des nächsten übergeordneten Albums oder den globalen Standard erben.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Erben',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Wirksame Einstellung: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Wirksamer Wert: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Versionen nach Album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Diese schreibgeschützte Übersicht folgt der Albumhierarchie. Mit Bearbeiten änderst du ein Album oder Unteralbum.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Album',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Geerbt',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Direkte Einstellung',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Auf %1$d gesetzt',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'Es sind keine öffentlichen Gallery-Alben vorhanden.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Darf Einstellungen für Bildversionen verwalten',
]);
