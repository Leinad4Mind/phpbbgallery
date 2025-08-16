<?php

/**
 *
 * Invitation. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
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
// Some characters you may want to copy&paste: ’ « » „ “ ” …

$lang = array_merge($lang, array(
	'AUTH_CACHE_PURGE'						=> 'Befugniscache leeren',

	'CACHE_PURGE'							=> 'Forumscache leeren',
	'CAT_INSTALL'							=> 'Installieren',
	'CAT_OVERVIEW'							=> 'Übersicht',
	'CAT_UNINSTALL'							=> 'Deinstallieren',
	'CAT_UPDATE'							=> 'Aktualisieren',
	'CAT_VERIFY'							=> 'Verifizieren',

	'GPL'									=> 'General Public License',

	'INCOMPLETE_FILES_UPLOAD'				=> 'Die phpBB Invite-Dateien wurden unvollständig hochgeladen. Bitte stelle sicher, dass alle Dateien zunächst hochgeladen worden sind, bevor du mit der Installation beginnst.',
	'INCOMPLETE_FILE_EDITS'					=> 'Einige Dateien wurden nicht vollständig geändert, diese müssen zunächst geändert werden, bevor die Installation durchgeführt werden kann!',
	'INCOMPLETE_LANG_ROWS'					=> 'Einige Änderungen an den Sprachdateien fehlen. Bitte nehme diese zunächst, wie %sHIER%s beschrieben, vor.',
	'INSTALLATION'							=> 'phpBB Invite installieren',
	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite: Datenbank installieren.<br /><br />',
	'INSTALL_BODY'							=> 'Hier kannst du sehen, dass die Mod korrekt installiert wurde, und funktionstüchtig ist.',
	'INSTALL_ERR_AUTH'						=> 'Du bist nicht befugt, dieses Script zu verwenden.<br /><br />Bitte beachte, dass, um dieses Script auszuführen, folgende Bedingungen erfüllt sein müssen. Du musst zunächst eingeloggt, und Gründer des Forums sein. Falls du angemeldet und Gründer bist, sind eventuell deine Cookieeinstellungen im ACP fehlerhaft. Bitte überprüfe die Cookiedomäneneinstellung. Falls deine Seiten-URL <strong>http://www.beispiel.de</strong> ist, dann sollte die Einstellung <strong>.beispiel.de</strong> lauten.',
	'INSTALL_FOLDER'						=> '<strong>Bitte lösche das <em>install</em>-Verzeichnis. So lange du das nicht getan hast, wird nur das ACP zugänglich sein.</strong>',
	'INSTALL_LOGIN'							=> 'Weiter ins ACP',

	'INVITE_CONFIG_ADD'						=> 'Neue phpBB Invite-Konfiguration hinzufügen: %s',
	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'phpBB Invite-Konfigurationsvariable %s existiert bereits.',
	'INVITE_CONFIG_NOT_EXIST'				=> 'phpBB Invite-Konfigurationsvariable %s existiert nicht.',
	'INVITE_CONFIG_REMOVE'					=> 'phpBB Invite-Konfiguration Spalte gelöscht: %s',
	'INVITE_CONFIG_UPDATE'					=> 'phpBB Invite-Konfiguration geändert: %s',
	'INVITE_INSTALL_INTRO'					=> 'Willkommen zur Installation der phpBB Invite',
	'INVITE_INSTALL_INTRO_BODY'				=> 'Mit dieser Option kannst du die phpBB Invite in deiner Datenbank einrichten.',

	'MEGHIVO_VERSION'						=> 'Die installierte phpBB Invite-Version ist <b>%s</b>, diese Datei kann zur Aktualisierung von Version <b>%s</b> auf Version <b>%s</b> verwendet werden. <br /> Du musst erst auf Version <b>%s</b> aktualisieren, um dieses Aktualisierungsscript verwenden zu können!',

	'NOT_INSTALL_DIR'						=> 'Kann das Installationsverzeichnis nicht öffnen!',
	'NOT_LANGUAGE_DIR'						=> 'Die Sprachbibliothek ist nicht verfügbar!',
	'NOT_LANGUAGE_DIR_DIR'					=> 'Das Verzeichnis für die Sprache %s kann nicht gefunden werden!',
	'NOT_MODULE'							=> 'Die Installationsmodule sind nicht verfügbar!',
	'NOT_MODULE_OPEN'						=> 'Modul %s ist nicht verfügbar!',
	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Fehler:</span> Die Tabellendaten fehlen.',

	'OVERVIEW_BODY'							=> 'Willkommen!<br /><br />Das Installationssystem zeigt eine vollständige Anleitung, wie die Mod installiert, oder entfernt, oder aktualisiert wird.<br />Mit dem Auswahlmenü fortfahren... Wähle die passende Option aus dem Menü aus.',

	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Fehler:</span> Die Hauptkategorie, die das neue Modul anzeigen soll, existiert nicht.',
	'PERMISSIONS_WARNING'					=> 'Neue Befugniseinstellungen wurden hinzugefügt.  Überprüfe deine Befugniseinstellungen, und stelle sicher, dass sie so vorliegen, wie du sie gern hättest.',
	'PHPBB_INVITE_DONATE'					=> 'Bitte erwäge eine kleine Spende, um die vielen Stunden harter Arbeit zu belohnen, die nötig waren, um „phpBB Invite“ zu entwickeln.',
	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite: Spenden',
	'PHPBB_VERSION'							=> 'Deine phpBB-Version ist <b>%s</b>, phpBB Invite benötigt Version <b>%s</b>!',
	'PHP_VERSION_RUN'						=> 'Die momentane PHP-Version wird nicht unterstützt, bitte aktualisiere PHP auf Version 4.3.3 oder höher, bevor du die Installation ausführst.</b>',

	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Fehler:</span> diese Rolle gibt es nicht in der Datenbank.',

	'STAGE_INSTALL'							=> 'Installieren',
	'STAGE_INTRO'							=> 'Einführung',
	'STAGE_UNINSTALL'						=> 'Datenbank löschen',
	'STAGE_VERIFY'							=> 'Verifizieren',
	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />Die Moddateien wurden erfolgreich gelöscht.',
	'SUB_INTRO'								=> 'Einführung',
	'SUB_LICENSE'							=> 'Lizenz',
	'SUB_SUPPORT'							=> 'Unterstützung',
	'SUCCESS'								=> '<span style="color:#000;"><b>Erfolgreich abgeschlossen.</b></span>',
	'SUPPORT_BODY'							=> 'Für die aktuelle und kommende Versionen wird völlig kostenlos volle Unterstützung gewährt.<br />Dies beinhaltet:</p><ul><li>Informationen</li><li>Konfiguration</li><li>ältere Versionen auf die neue Version aktualisieren</li></ul><p>Ich empfehle jedem, der eine ältere Version verwendet, auf die neue Version zu aktualisieren.</p><h2>Supportforen</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">Die Hauptentwicklungssite</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com-Entwicklungsthema</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu-Entwicklungsthema</a><br /><br />',

	'UNINSTALL_BODY'						=> 'Hier kannst du sehen, dass die Datenbankeinträge der Mod erfolgreich gelöscht wurden.<br /><br /><b>Bitte lösche das <em>install</em>-Verzeichnis. So lange du das nicht getan hast, wird nur das ACP zugänglich sein.</b>',
	'UNINSTALL_INTRO'						=> 'phpBB Invite löschen',
	'UNINSTALL_INTRO_BODY'					=> 'Benutze diese Option um die phpBB Invite aus deiner Datenbank zu entfernen.',
	'UNINSTALL_TITLE'						=> 'phpBB Invite aus der Datenbank entfernen',
	'UPDATE_BODY'							=> 'Hier kannst du sehen, dass die Datenbankeinträge der Mod erfolgreich aktualisiert wurden.<br /><br /><b>Bitte lösche das <em>install</em>-Verzeichnis. So lange du das nicht getan hast, wird nur das ACP zugänglich sein.</b>',
	'UPDATE_INSTALLATION'					=> 'phpBB Invite aktualisieren',
	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite auf die neueste Version aktualisieren.<br />',
	'UPDATE_TITLE'							=> 'Aktualisiere Datenbank',

	'VERIFY_ERROR_EXPLAIN'					=> 'Die Überprüfung fand einen Fehler.',
	'VERIFY_ERROR_FILE'						=> 'Fehlerhafte Dateiänderung.',
	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Hier kannst du die Dateien sehen, die fehlerhaft geändert oder ausgelassen wurden.',
	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />Den hier angezeigten SQL-Befehl kannst du selbst ausführen, wenn du ihn in phpMyAdmin lädst.',
	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">nicht gefunden!</span></b><br />%s<br />',
	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite: Konfiguration',
	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>Jede Konfiguration gefunden.</strong></span>',
	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite: Dateien',
	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>Alle Dateien gefunden.</strong></span>',
	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite: Module',
	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>Alle Module gefunden.</strong></span>',
	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite: Befugnisse',
	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>Alle Befugnisse gefunden.</strong></span>',
	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite: Tabellen',
	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>Alle Tabellen gefunden.</strong></span>',
	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">nicht gefunden!</span></b>',
	'VERIFY_NOT_COLUMN'						=> 'Fehlende Spalten',
	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Hier kannst du alle Spalten sehen, die nicht installiert wurden.',
	'VERIFY_NOT_CONFIG'						=> 'Fehlende Konfiguration',
	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Hier kannst du die Konfigurationsdateien sehen, die nicht installiert wurden.',
	'VERIFY_NOT_FILE'						=> 'Fehlende Dateien',
	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Hier kannst du alle Dateien sehen, die nicht korrekt hochgeladen wurden, oder korrekt, aber am falschen Ort hochgeladen wurden.',
	'VERIFY_NOT_INVITE_CONFIG'				=> 'Fehlende phpBB Invite-Konfiguration',
	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Hier kannst du die Konfigurationsdateien für die phpBB Invite sehen, die nicht installiert wurden.',
	'VERIFY_NOT_MODULE'						=> 'Fehlende Module',
	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Hier kannst du die Module sehen, die nicht installiert wurden.',
	'VERIFY_NOT_PERMIS'						=> 'Fehlende Befugnisse',
	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Hier kannst du die Befugnisse sehen, die nicht installiert wurden.',
	'VERIFY_NOT_TABLE'						=> 'Fehlende Tabellen',
	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Hier kannst du die Tabellen sehen, die nicht installiert wurden.',
	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span>-<span style="color:#000;">Spalte nicht gefunden!</span></b><br />%s<br />',
	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span>-<span style="color:#000;">Modul konnte in der Datenbank nicht gefunden werden!</span></b>',
	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span>-<span style="color:#000;">Befugnis konnte in der Datenbank nicht gefunden werden!</span></b>',
	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span>-<span style="color:#000;">Tabelle konnte in der Datenbank nicht gefunden werden!</span></b>%s',
	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB-Benutzertabelle: neue Spalten',
	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>Alle Spalten gefunden.</strong></span>',
	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB: neue Konfiguration',
	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB-Konfiguration gefunden.</strong></span>',
	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB-Dateiänderungen',
	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>Alle Dateien wurden geändert.</strong></span>',
	'VERIFY_SUCCESS_EXPLAIN'				=> 'Die Überprüfung fand alles in ordnungsgemäßem Zustand vor.',
	'VERIFY_TITLE'							=> 'phpBB Invite Überprüfung',
	'VERIFY_TITLE_ELL'						=> 'Prüfungsfehler',
	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Hier kannst du alle aufgetretenen Fehler sehen, um sie mit Bedacht beheben zu können!</b></span>',
	'VERIFY_TITLE_EXPLAIN'					=> '<br />Hier kannst du überprüfen, ob alle notwendigen Dateiänderungen, Konfigurationsänderungen und Datenbankeinträge erfolgreich vorgenommen wurden.',
	'VERIFY_UJ'								=> 'Erneut prüfen',
	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Vorhandene Dateien',
	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Hier kannst du die Dateien sehen, die nicht entfernt werden konnten.',
));
