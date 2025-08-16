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
	'AUTH_CACHE_PURGE'						=> 'Wissen permissie cache',

	'CACHE_PURGE'							=> 'Wis forum cache',
	'CAT_INSTALL'							=> 'Installeer',
	'CAT_OVERVIEW'							=> 'Overzicht',
	'CAT_UNINSTALL'							=> 'Verwijderen',
	'CAT_UPDATE'							=> 'Update',
	'CAT_VERIFY'							=> 'Verifieer',

	'GPL'									=> 'General Public License',

	'INCOMPLETE_FILES_UPLOAD'				=> 'De uitnodigings bestanden zijn onvolledig geüpload. Zorg ervoor dat alle bestanden geupoload zijn voordat u het installatieprogramma uitvoert.',
	'INCOMPLETE_FILE_EDITS'					=> 'De bestands wijzigingen zijn niet uitgevoerd. Zorg dat je de bestands wijzigingen uitvoerd voor dat je verder gaat met installeren.',
	'INCOMPLETE_LANG_ROWS'					=> 'Sommige veranderingen in de taal bestanden missen. Verander of voeg ze toe zoals %sHier%s is omschreven.',
	'INSTALLATION'							=> 'phpBB Uitnodiging installeren',
	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Uitnodiging database installeren.<br /><br />',
	'INSTALL_BODY'							=> 'Hier kunt u zien dat de mod aanwezig is en goed is geïnstalleerd.',
	'INSTALL_ERR_AUTH'						=> 'U bent niet gemachtigd om dit script gebruiken.<br /><br />Let op: voor het gebruik van het script moet aan de volgende eisen worden voldaan. ten eerste moet je ingelogd zijn op de site en ten tweede moet de gebruikers type eigenaar zijn. Als je bent ingelogd als eigenaar, dan heb je onjuiste cookie-instellingen . Contoleer de cookie domain instellingen. Als je site URL is <strong>http://www.example.com</strong> dan zou je cookie domain moeten zijn <strong>.example.com</strong>.',
	'INSTALL_FOLDER'						=> '<strong>Verwijder de installatie map. Als je dit niet doet, is je ACP alleen bereikbaar.</strong>',
	'INSTALL_LOGIN'							=> 'Ga verder naar ACP',

	'INVITE_CONFIG_ADD'						=> 'Toevoegen nieuwe uitnodigen config variabele: %s',
	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Uitnodigen config variable %s bestaat al.',
	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Uitnodigen config variable %s bestaat niet.',
	'INVITE_CONFIG_REMOVE'					=> 'Verwijder Uitnodigen config variable: %s',
	'INVITE_CONFIG_UPDATE'					=> 'Updating Uitnodigen config variable: %s',

	'INVITE_INSTALL_INTRO'					=> 'Welkom bij de phpBB Uitnodigen Installatie',
	'INVITE_INSTALL_INTRO_BODY'				=> 'Met deze optie, is het mogelijk om de phpBB Uitnodigen te installeren in jouw database.',

	'MEGHIVO_VERSION'						=> 'De phpBB Uitnodigen versie is <b>%s</b>, deze  data is een verversing van de versie <b>%s</b> - naar versie <b>%s</b> kan gebruikt worden om te updaten. <br /> Je moet eerst upgraden naar versie <b>%s</b> om dit script te kunnen gebruiken!',

	'NOT_INSTALL_DIR'						=> 'Kan de installatie map niet openen!',
	'NOT_LANGUAGE_DIR'						=> 'De bibliotheek van de taal is niet beschikbaar!',
	'NOT_LANGUAGE_DIR_DIR'					=> 'De  %s taal directory kan niet gevonden worden!',
	'NOT_MODULE'							=> 'De installatie modules zijn niet beschikbaar!',
	'NOT_MODULE_OPEN'						=> '%s Module is niet beschikbaar!',
	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> De tabel data mist.',

	'OVERVIEW_BODY'							=> 'Welkom!<br /><br />De volledige systeem installatiegids toont de mod installatie of verwijdering en updates.<br />Kies in het menu ga door... selecteer de gewenste optie.',

	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> De bovenliggende categorielaat zien dat de nieuwe module niet bestaat.',
	'PERMISSIONS_WARNING'					=> 'Nieuwe permissie instellingen zijn toegevoegd. Contoleer je  permissie instellingen en kijk of je ze zo wilt hebben.',
	'PHPBB_INVITE_DONATE'					=> 'Maak een kleine donatie over om het harde werk en vele uren te waarderen die gebruikt zijn om de “phpBB Uitnodiging” te maken.',
	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Uitnodiging donatie',
	'PHPBB_VERSION'							=> 'JouwphpBB versie <b>%s</b>, De phpBB Uitnodiging mod vereist versie <b>%s</b>!',
	'PHP_VERSION_RUN'						=> 'De huidige PHP versie wordt niet ondersteund, update jouw versie PHP naar versie 4.3.3 of hoger voordat je de installatie uitvoert.</b>',

	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> deze rol zit niet in the database.',

	'STAGE_INSTALL'							=> 'Installeer',
	'STAGE_INTRO'							=> 'Intro',
	'STAGE_UNINSTALL'						=> 'Verwijder database',
	'STAGE_VERIFY'							=> 'Controleer',
	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />De mod bestanden zijn met succes verwijderd.',
	'SUB_INTRO'								=> 'Intro',
	'SUB_LICENSE'							=> 'Licentie',
	'SUB_SUPPORT'							=> 'Support',
	'SUCCESS'								=> '<span style="color:#000;"><b>Met succes afgerond!</b></span>',
	'SUPPORT_BODY'							=> 'Volledige steun zal worden verleend voor de huidige versies van de introductie en ontwikkeling, geheel kostenloos.<br />Dit omvat:</p><ul><li>informatie</li><li>configuratie</li><li>update oudere versies naar de nieuwste versie</li></ul><p>Wij moedigen iedereen  die met een oudere versie werkt om te upgraden naar de nieuwe versie.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',

	'UNINSTALL_BODY'						=> 'Hier kunt u zien dat de mod database gegevens zijn verwijderd.<br /><br /><b>Verwijder de installatie map. Als je dit niet doet, is alleen je ACP bereikbaar..</b>',
	'UNINSTALL_INTRO'						=> 'phpBB Uitnodigen verwijderen',
	'UNINSTALL_INTRO_BODY'					=> 'Met deze optie kun je de phpBB uitnodiging verwijderen uit de database.',
	'UNINSTALL_TITLE'						=> 'phpBB uitnodigen verwijderd uit de database',
	'UPDATE_BODY'							=> 'Hier kunt je zien dat de mod aanwezig is en goed is bijgewerkt.<br /><br /><b>Verwijder de installatie map. Als je dit niet doet, is alleen je ACP bereikbaar..</b>',
	'UPDATE_INSTALLATION'					=> 'phpBB Uitnodiging update',
	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Uitnodigen bijgewerkt naar de nieuwste versie.<br />',
	'UPDATE_TITLE'							=> 'Bijwerken database data',

	'VERIFY_ERROR_EXPLAIN'					=> 'De controle heeft een fout gevonden.',
	'VERIFY_ERROR_FILE'						=> 'Slechte bestand wijziging',
	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Hier kan je de bestanden zien die slecht zijn bewerkt of zijn weggelaten.',
	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />Je kunt de SQL-opdracht hieronder, in phpMyAdmin zelf uitvoeren.',
	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">niet gevonden!</span></b><br />%s<br />',
	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB uitnodiging configuratie',
	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>Alle phpBB `Uitnodiging config gevonden.</strong></span>',
	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Uinodiging bestanden',
	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>Alle bestanden gevonden.</strong></span>',
	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Uitnodiging modules',
	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>Alle modules gevonden.</strong></span>',
	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Uitnodiging permissies',
	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>Alle permissies gevonden.</strong></span>',
	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Uinodiging tabellen',
	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>Alle tablellen gevonden.</strong></span>',
	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">niet gevonden!</span></b>',
	'VERIFY_NOT_COLUMN'						=> 'Ontbrekende kolommen',
	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Hier ziet u alle kolommen die niet zijn geïnstalleerd.',
	'VERIFY_NOT_CONFIG'						=> 'Ontbrekende config',
	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Hier kunt u de configuratiebestanden zien die niet zijn geïnstalleerd.',
	'VERIFY_NOT_FILE'						=> 'Ontbrekende bestanden',
	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Hier ziet u de bestanden die niet goed zijn of niet zijn geïnstalleerd of geïnstalleerd zijn op de verkeerde plaats.',
	'VERIFY_NOT_INVITE_CONFIG'				=> 'Ontbrekende Uitnodiging config',
	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Hier kun je de phpBB Uitnodiging config bestanden controleren welke nog niet zijn geinstalleerd.',
	'VERIFY_NOT_MODULE'						=> 'Ontbrekende modules',
	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Hier kun je de modules zien welke nog niet zijn geinstalleerd.',
	'VERIFY_NOT_PERMIS'						=> 'Ontbrekende permissies',
	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Hier kun je de permissies zien die niet zijn geinstalleerd.',
	'VERIFY_NOT_TABLE'						=> 'Ontbrekende tabellen',
	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Hier ziet je de tekens die niet zijn geïnstalleerd.',
	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">kolom niet gevonden!</span></b><br />%s<br />',
	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is niet gevonden in de database!</span></b>',
	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permissie is niet gevonden in de database!</span></b>',
	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">tabel is niet gevonden in de database!</span></b>%s',
	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB gebruikers tabel nieuwe kolommen',
	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>Alle kolommen gevonden.</strong></span>',
	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config gevonden.</strong></span>',
	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>Alle bestanden zijn gewijzigd.</strong></span>',
	'VERIFY_SUCCESS_EXPLAIN'				=> 'De controle check heeft alles in orde bevonden.',
	'VERIFY_TITLE'							=> 'phpBB Uitnodiging controle',
	'VERIFY_TITLE_ELL'						=> 'Controle error',
	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Hier ziet u alle opgetreden fouten om zorgvuldig alles op te lossen!</b></span>',
	'VERIFY_TITLE_EXPLAIN'					=> '<br />Hier is uw kans om te controleren of de vereiste bewerkingen en de benodigde database-bestanden correct zijn geïnstalleerd of bijgewerkt.',
	'VERIFY_UJ'								=> 'Controleer opnieuw',
	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Bestaande bestanden',
	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Hier kun je zien welke bestanden niet zijn verwijderd.',
));
