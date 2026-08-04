<?php
/**
 * phpBB Gallery - BBPoints Images
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'Die erforderlichen Erweiterungen sind nicht aktiviert: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints für Bilder',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Belohnungen für Veröffentlichungen in der Galerie und Kosten für den Zugriff auf Originaldateien konfigurieren.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Globale Einstellungen',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Belohnung pro freigegebenem Bild',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Punkte, die dem endgültigen Autor bei der Freigabe einmalig gutgeschrieben werden. Mit 0 werden Belohnungen deaktiviert.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Kosten der Originaldatei',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Erforderliche Punkte für den Zugriff auf die Originaldatei. Mit 0 ist der Zugriff kostenlos.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Album-Ausnahmen',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Diese schreibgeschützte Übersicht folgt der Galeriehierarchie. Bearbeite ein Album, um direkte Werte zu ändern; fett dargestellte Werte sind aktuell wirksam.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS_EXPLAIN' => 'Mit -1 erbt jeder Zahlenwert unabhängig vom nächsten konfigurierten Vorfahren oder von der globalen Einstellung.',
	'ACP_BBPOINTSIMAGES_INHERIT' => 'Erben',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Mit -1 wird der Wert vom nächsten konfigurierten Vorfahren oder aus der globalen Einstellung geerbt.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_VALUE' => 'Wirksamer Wert: %1$d.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_TOGGLE' => 'Wirksame Einstellung: %1$s.',
	'ACP_BBPOINTSIMAGES_INHERITED' => 'Geerbt',
	'ACP_BBPOINTSIMAGES_DIRECT_VALUE' => 'Direkter Wert: %1$d',
	'ACP_BBPOINTSIMAGES_DIRECT_SETTING' => 'Direkte Einstellung',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Es sind keine Galerie-Alben verfügbar.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Die Einstellungen für BBPoints für Bilder wurden gespeichert.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Belohnungen für vorhandene Bilder',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Freigegebene vorhandene Bilder prüfen und die konfigurierte Belohnung vergeben. Vorhandene Belohnungen und exakt gleiche Dateien werden übersprungen.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Vorhandene Belohnungen synchronisieren',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Möchtest du wirklich alle berechtigten vorhandenen Bilder nach den aktuellen Albumregeln belohnen?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'Die Synchronisierung läuft weiter. Bisher wurden %1$d Bilder geprüft und %2$d Belohnungen vergeben.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'Die Synchronisierung wurde abgeschlossen. %1$d Bilder wurden geprüft und %2$d Belohnungen vergeben.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Du musst dich anmelden, um diese Originalbilddatei zu kaufen.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Das Herunterladen dieser Originalbilddatei kostet %1$d Punkte. Möchtest du fortfahren?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'Du hast %1$d Punkte, aber diese Originalbilddatei erfordert %2$d Punkte.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'Die Originalbilddatei kann derzeit nicht gekauft werden.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Original-Downloads',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Zuweisung von Mitwirkenden erlauben',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Erlaubt Bildautoren und Bearbeitern, Mitwirkende einzutragen. Bereits eingetragene Mitwirkende behalten ihre Nennung und ihren Anteil an bezahlten Downloads, wenn diese Option deaktiviert wird.',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK' => 'Mitwirkende in allen Alben',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_EXPLAIN' => 'Legt für alle öffentlichen Alben eine ausdrückliche Auswahl fest oder setzt alle auf die globale Vererbung zurück. Abweichende Belohnungen und Kosten bleiben erhalten.',
	'ACP_BBPOINTSIMAGES_INHERIT_GLOBAL' => 'Alle Alben erben lassen',
	'ACP_BBPOINTSIMAGES_ENABLE_ALL' => 'In allen Alben aktivieren',
	'ACP_BBPOINTSIMAGES_DISABLE_ALL' => 'In allen Alben deaktivieren',
	'ACP_BBPOINTSIMAGES_APPLY_ALL' => 'Auf alle Alben anwenden',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_CONFIRM' => 'Soll die Zuweisung von Mitwirkenden wirklich für alle öffentlichen Galeriealben geändert werden?',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_SAVED' => 'Die Zuweisung von Mitwirkenden wurde für alle öffentlichen Galeriealben aktualisiert.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Mitwirkende',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Gib pro Zeile einen registrierten Benutzernamen ein, maximal %1$d. Der Bildautor wird automatisch ausgeschlossen.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'Diese Mitwirkenden wurden nicht gefunden oder sind inaktiv: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'Ein Bild darf höchstens %1$d Mitwirkende haben.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD' => 'Belohnungen für Galerie-Bilder',
	'NOTIFICATION_BBPOINTSIMAGES_REWARD' => 'Du hast %1$d Punkte für die Veröffentlichung des Bildes <strong>%2$s</strong> erhalten.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE' => 'Verkäufe von Galerie-Originaldateien',
	'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE' => '%1$s hat die Originaldatei von <strong>%3$s</strong> gekauft; du hast %2$d Punkte erhalten.',
]);
