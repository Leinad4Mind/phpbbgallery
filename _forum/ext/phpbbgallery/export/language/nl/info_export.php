<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Dutch [nl]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core ontbreekt! Download en installeer het vóór deze extensie.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'De extensie is met succes ingeschakeld.',

	'EXPORT_SELECTION'				=> 'Wat er geëxporteerd wordt',
	'EXPORT_ALBUMS'					=> 'Albums',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Kies een of meer albums. Houd Ctrl ingedrukt om er meerdere te selecteren.',
	'EXPORT_ALL_ALBUMS'				=> 'De hele galerij exporteren en de selectie hierboven negeren',
	'EXPORT_DELIVERY'				=> 'Bestemming van het archief',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Een archief dat op de server blijft staan wordt naar %s geschreven en wordt nooit automatisch verwijderd, zodat je het via FTP kunt ophalen wanneer je wilt.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Als download aanbieden',
	'EXPORT_DELIVERY_SERVER'		=> 'Op de server laten staan',
	'EXPORT_LIMITS'					=> 'Limieten',
	'EXPORT_LIMITS_EXPLAIN'			=> 'Hoogstens %1$d afbeeldingen en %2$s per export, waarbij %3$d afbeeldingen tegelijk worden weggeschreven.',
	'EXPORT_SETTINGS'				=> 'Exportinstellingen',
	'EXPORT_MAX_IMAGES'				=> 'Maximumaantal afbeeldingen per export',
	'EXPORT_MAX_IMAGES_EXPLAIN'		=> 'Maximumaantal afbeeldingen in één export. De veiligheidslimiet is %d.',
	'EXPORT_MAX_SIZE_MIB'			=> 'Maximumgrootte per export (MiB)',
	'EXPORT_MAX_SIZE_MIB_EXPLAIN'	=> 'Maximale totale grootte van de originele bestanden. De veiligheidslimiet is %d MiB.',
	'EXPORT_BATCH_SIZE'				=> 'Afbeeldingen per batch',
	'EXPORT_BATCH_SIZE_EXPLAIN'		=> 'Aantal afbeeldingen dat per aanvraag wordt geschreven. Lagere waarden beperken geheugen- en timeoutrisico. De limiet is %d.',
	'EXPORT_SETTINGS_SAVED'			=> 'De exportinstellingen zijn opgeslagen.',
	'EXPORT_START'					=> 'Export starten',
	'EXPORT_CONTINUE'				=> 'Doorgaan',
	'EXPORT_DOWNLOAD'				=> 'Downloaden',

	'EXPORT_STARTED'				=> [
		1	=> 'De export van %d afbeelding is gestart.',
		2	=> 'De export van %d afbeeldingen is gestart.',
	],
	'EXPORT_PROGRESS'				=> '%1$d van %2$d afbeeldingen geëxporteerd…',
	'EXPORT_FINISHED'				=> [
		1	=> 'De export is afgerond met %d afbeelding.',
		2	=> 'De export is afgerond met %d afbeeldingen.',
	],

	'EXPORT_JOBS'					=> 'Exports',
	'EXPORT_NO_JOBS'				=> 'Er zijn nog geen exports.',
	'EXPORT_JOB_ARCHIVE'			=> 'Archief',
	'EXPORT_JOB_CREATED'			=> 'Gestart',
	'EXPORT_JOB_PROGRESS'			=> 'Voortgang',
	'EXPORT_JOB_SIZE'				=> 'Grootte',
	'EXPORT_JOB_ACTION'				=> 'Actie',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> '%d afbeelding kon niet worden toegevoegd.',
		2	=> '%d afbeeldingen konden niet worden toegevoegd.',
	],
	'EXPORT_JOB_DELETED'			=> 'De export is verwijderd.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Die export bestaat niet of is niet van jou.',
	'EXPORT_STATUS_READY'			=> 'Klaar',
	'EXPORT_STATUS_RUNNING'			=> 'Bezig',

	'EXPORT_UCP_EXPLAIN'			=> 'Hier kun je de afbeeldingen downloaden die je hebt geüpload, met de namen die de galerij toont in plaats van de namen waaronder ze op schijf staan. Tot %d afbeeldingen per export.',
	'EXPORT_UCP_DISABLED'			=> 'De beheerder heeft het exporteren van je eigen afbeeldingen uitgeschakeld.',

	'EXPORT_NO_IMAGES'				=> 'Er zijn geen afbeeldingen om te exporteren.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Een export mag hoogstens %d afbeeldingen omvatten. Exporteer minder albums tegelijk.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Een export mag hoogstens %s groot zijn. Exporteer minder albums tegelijk.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'Er is niet genoeg vrije ruimte op de server voor deze export.',
	'EXPORT_ARCHIVE_FAILED'			=> 'Het archief kon niet worden weggeschreven.',
	'EXPORT_ARCHIVE_MISSING'		=> 'Het archief van deze export staat niet meer op de server.',
	'EXPORT_STATE_FAILED'			=> 'De status van deze export kon niet worden opgeslagen. Controleer of de exportmap beschrijfbaar is.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Afbeelding %1$d is overgeslagen: het bestand “%2$s” staat niet op de server.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Afbeelding %1$d is overgeslagen: het bestand “%2$s” kon niet worden gelezen.',
	'EXPORT_ERROR_ARCHIVE'			=> 'Het archief “%s” kon niet worden weggeschreven.',
]);
