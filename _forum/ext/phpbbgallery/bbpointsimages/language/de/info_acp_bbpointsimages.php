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
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Jeder Wert überschreibt unabhängig den nächsten Vorfahren. Mit -1 wird der Wert geerbt.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Mit -1 wird der Wert vom nächsten konfigurierten Vorfahren oder aus der globalen Einstellung geerbt.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Es sind keine Galerie-Alben verfügbar.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Die Einstellungen für BBPoints für Bilder wurden gespeichert.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Belohnungen für vorhandene Bilder',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Freigegebene vorhandene Bilder prüfen und die konfigurierte Belohnung vergeben. Vorhandene Belohnungen und exakt gleiche Dateien werden übersprungen.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Vorhandene Belohnungen synchronisieren',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Möchtest du wirklich alle berechtigten vorhandenen Bilder nach den aktuellen Albumregeln belohnen?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'Die Synchronisierung läuft weiter. Bisher wurden %1$d Bilder geprüft und %2$d Belohnungen vergeben.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'Die Synchronisierung wurde abgeschlossen. %1$d Bilder wurden geprüft und %2$d Belohnungen vergeben.',
]);
