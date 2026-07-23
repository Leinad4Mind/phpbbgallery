<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'SPECIAL_ACTIVITY_STATS_INSTALLED' => 'Installierte Version: v%s',

	'SPECIAL_ACTIVITY_STATS_TITLE'    => 'Aktivitäts Statistiken',
	'SPECIAL_ACTIVITY_STATS_DISP_SET' => 'Anzeige Einstellungen',
	'SPECIAL_ACTIVITY_STATS_OTHER'    => 'Andere Einstellungen',

	// acp form
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'     => 'Anzeige neuer Themen',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP' => 'Zeigt die Anzahl neuer Themen an',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'      => 'Anzeige neuer Beiträge',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'  => 'Zeigt die Anzahl neuere Beiträge an',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'      => 'Anzeige neuer Benutzer',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'  => 'Zeigt die Anzahl neuer Benutzer an',

	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'        => 'Anzeige von Bots',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'    => 'Manche Benutze wissen nicht was Bots sind und wundern sich ggf.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'      => 'Anzeige von Gästen',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'  => 'Sollen Gäste im Zähler angezeigt werden?',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'      => 'Anzeige von unsichtbaren Benutzern',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'  => 'Sollen unsichtbare Benutzer in der Liste angezeigt werden? (Benötigt separate Berechtigung)',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'        => 'Anzeige Uhrzeit',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'    => 'Alle Benutze sehen es oder keiner. Keine Spezielle Funktion für Administratoren.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT' => 'Zeitformat',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'       => 'Anzeige beim hovern',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'          => 'Anzeige der Benutzer IP Adresse',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'      => 'Nur für Benutzer mit Administratoren Rechten, wie z.B. für wer-ist-online',

	'SPECIAL_ACTIVITY_STATS_RECORD'            => 'Rekorde',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'        => 'Anzeige und Speicherung von Besucher Rekorden',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT' => 'Datumsformat für den Besucher Rekord',
	'SPECIAL_ACTIVITY_STATS_RESET'             => 'Besucher Rekord zurücksetzen',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'         => 'Setzt die Zeit und den Zähler der Aktivitäts Statistiken zurück.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'        => 'Wenn Du diesen Befehl sendest,\nwird der Besucher Rekord zurückgesetzt.',


	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED' => 'Konfiguration wurde erfolgreich aktualisiert.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'        => 'Sortiere Benutzer nach',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'    => 'In welcher Reihenfolge sollen die Besucher sortiert werden?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'      => 'Benutzername A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'      => 'Benutzername Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'      => 'Zeit des Besuchs aufsteigend',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'      => 'Zeit des Besuchs absteigend',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'      => 'Benutzer-ID aufsteigend',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'      => 'Benutzer-ID absteigend',

	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'     => 'Cache Zeit (Sekunden)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP' => 'Zeitraum in welcher die Daten nicht neu berechnet werden (verbessert die Leistung)',

	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'     => 'Berechtigunen prüfen',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP' => 'Nein = jeder sieht die Aktivitäts Statistiken. (Ignoriere die Berechtigungseinstellungen); Ja = Verwende die vergebenen Berechtigungen z.B. Erlaube es nur für registierte Benutzer: ACP -> Berechtigungen -> Allgemeine Berechtigungen -> Gruppenrechte -> Registrierte Benutzer -> Erweiterte Berechtigungen -> Diverses -> "Kann Aktivitäts Statistiken sehen")',

	'SPECIAL_ACTIVITY_STATS_MODE'             => 'Anzeige Benutzer von ...',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'         => 'Anzeige Benutzer von heute (seit 00:00 Board Zeitzone), oder von einem Zeitraum definiert in folgender Einstellung:',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'       => 'Heute',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'      => 'Zeitraum',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'  => 'Gib 0 ein, wenn Du die letzten 24 Stunden angezeigt bekommen möchtest',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2' => 'Deaktiviert, wenn Du die Einstellung "Heute" verwendest.',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3' => 'Sekunden',

]);
