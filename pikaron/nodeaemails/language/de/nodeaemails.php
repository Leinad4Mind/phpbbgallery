<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
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

$lang = array_merge($lang, array(
		'NO_DEA_EMAILS_INSTALL_ERROR'		=> '“No DEA Emails” kann nicht installiert werden.<br><br>- phpBB 3.2.4 oder höher wird benötigt.',
		'NO_DEA_EMAILS_NO_CURL'				=> '“No DEA Emails” kann nicht installiert werden.<br><br>- Die PHP-Erweiterung “curl” müssen aktiviert sein.',
		'NO_DEA_EMAILS_FOUND'				=> 'FEHLER: Die E-Mail-Adresse ((%s)) ist nicht gültig.<br>Unsere Website unterstützt keine temporären, Einweg- oder Wegwerf-E-Mail-Adressen (<a href="https://de.wikipedia.org/wiki/E-Mail-Konto#Alias-Adressen_und_Wegwerf-E-Mail-Adressen" target="_blank">DEA</a>).<br>Wenn du unsere Seite nutzen möchtest, musst du eine dauerhaft zur Verfügung stehende E-Mail-Adresse angeben.',
		'NO_DEA_EMAILS_TITLE_FORCE_CHANGE'	=> 'Änderung durch Erweiterung "Keine deaktivierten E-Mails" erforderlich',
		'NO_DEA_EMAILS_FORCE_CHANGE'		=> 'Bevor Sie weiter auf der Website surfen, müssen Sie Ihre "E-Mail-Adresse" ändern.',
		'NO_DEA_EMAILS_NOT_FORCE_CHANGE'	=> 'Bevor Sie weiter auf der Website surfen, müssen Sie Ihre "E-Mail-Adresse" ändern.<br>Sie haben keine Berechtigung, die Änderung vorzunehmen.<br>Sie müssen sich an die Websiteverwaltung wenden und Ihre E-Mail-Adresse anfordern aktualisieren.',
		'LOG_NO_DEA_EMAILS'					=> 'No DEA Emails',
		'LOG_NO_DEA_EMAILS_SETTINGS'		=> 'CRON-Verwaltung und externe DEA-Mail-Domains',
		'LOG_NO_DEA_EMAILS_LOCALS'			=> 'Lokale Verwaltung von Mail-Domains DEA',
		'LOG_NO_DEA_EMAILS_USERS'			=> 'Benutzer mit DEA-Mail-Konten',
));
