<?php

/**
*
* @package phpBB Extension - Personal Notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/*
* [ german ] language file
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

$lang = array_merge($lang, [
	'ACP_NOTES'				=> 'Notizen einstellen',
	'ACP_NOTES_SETTINGS'	=> 'Max. Anzahl Notizen je Benutzer',
	'UCP_NOTES'				=> 'Notizen',
	'UCP_NOTES_CONFIG'		=> 'Einstellungen',

	'NOTES'				=> 'Notizen',
	'POPUP_NOTES'		=> 'Zeige persönliche Notizen als Popup',
	'SLIDE_NOTES'		=> 'Notizen als Titelliste öffnen, Anzeigen per Klick auf den Titel',
	'FILTER_NOTES'		=> '<strong>Filteranzeige</strong><br />Klicke erneut auf den Such-Button oder ändere die Sortierung, um alle Notizen anzuzeigen.',
	'NOTES_MEM'			=> 'An Notiz erinnern',
	'NOTES_MEM_TIME'	=> 'Erinnerungszeit',
	'NOTES_MEMTEXT'		=> '<strong>Du hast Notizen erfasst, an die Du erinnert werden wolltest.</strong><br />%sKlicke hier, um diese Notizen anzuzeigen.%s<br />(Du wirst danach nicht mehr an diese Notizen erinnert)',
	'NO_NOTES'			=> 'Du hast zur Zeit keine Notizen',

	'NOTES_CONFIG_SUCCESSFULL'	=> 'Die Einstellungen der Notizen wurden erfolgreich gespeichert.',
	'NOTES_LOG_CONFIG'			=> 'Anzahl Notizen je Benutzer geändert',
]);
