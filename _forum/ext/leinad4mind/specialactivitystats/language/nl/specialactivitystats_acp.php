<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2015 Rembert Oldenboom
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
	'SPECIAL_ACTIVITY_STATS_INSTALLED' => 'Geïnstalleerde versie: v%s',

	'SPECIAL_ACTIVITY_STATS_TITLE'    => 'Activiteitsstatistieken',
	'SPECIAL_ACTIVITY_STATS_DISP_SET' => 'Weergave settings',
	'SPECIAL_ACTIVITY_STATS_OTHER'    => 'Overige settings',

	// acp form
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'     => 'Toon nieuwe onderwerpen',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP' => 'Toont het aantal nieuw aangemaakte onderwerpen',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'      => 'Toont nieuwe bijdragen',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'  => 'Toont het aantal nieuwe bijdragen',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'      => 'Toon nieuwe gebruikers',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'  => 'Toont het aantal nieuwe gebruikers',

	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'        => 'Toon bots',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'    => 'Sommige gebruikers vragen zich mogelijk af wat bots zijn en maken zich daar zorgen over',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'      => 'Toon gasten',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'  => 'Moeten gasten in de teller worden getoond?',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'      => 'Toon verborgen gebruikers',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'  => 'Moeten verborgen gebruikers worden getoond in de lijst? (toestemming noodzakelijk)',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'        => 'Toon tijd',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'    => 'Alle gebruikers zien het, of niemand. Geen speciale admin functie.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT' => 'Tijdformaat',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'       => 'Toon bij hover',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'          => 'Toon user-ip',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'      => 'Alleen voor gebruikers met admin rechten, zoals bv. viewonline.php',

	'SPECIAL_ACTIVITY_STATS_RECORD'            => 'Statistieken opslaan',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'        => 'Tonen en opslaan bezoeker statistieken.',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT' => 'Datumformaat voor opgeslagen statistieken',
	'SPECIAL_ACTIVITY_STATS_RESET'             => 'Reset statistieken',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'         => 'Reset de tijd en teller van de statistieken.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'        => 'Met dit commando worden de bezoekerstatistieken op nul teruggezet.',


	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED' => 'Configuratie succesvol aangepast.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'        => 'Gebruikers sorteren op',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'    => 'In welke volgorde moeten gebruikers worden getoond?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'      => 'Gebruikersnaam A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'      => 'Gebruikersnaam Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'      => 'Tijdstip bezoek, oplopend',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'      => 'Tijdstip bezoek, aflopend',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'      => 'User-ID oplopend',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'      => 'User-ID aflopend',

	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'     => 'Cache periode (seconden)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP' => 'Periode waarin de data niet opnieuw herberekend wordt (verbetert prestatie)',

	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'     => 'Permissies checken',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP' => 'Ja=iedereen mag de aciviteitenstatistieken zien (negeert permissie-settings); Ja=gebruik geconfigureerde permissies (bv. om alleen toe te staan voor geregistreerde gebruikers:  ACP->permissies->globale permissies -> groep permissies -> registered users -> uitgebeide permissies -> diverse -> "Kan activiteitenstatistieken zien")',

	'SPECIAL_ACTIVITY_STATS_MODE'             => 'Toon gebruikers van ...',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'         => 'Toon de gebruikers van vandaag (vanaf 00:00 forum-tijdzone), of de hieronder opgegeven periode.',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'       => 'Vandaag',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'      => 'Periode',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'  => 'geef 0 om de gebruikers van de laatste 24 uur weer te geven',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2' => 'uitgeschakeld wanneer je "vandaag" hebt gekozen',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3' => 'seconden',

]);
