<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2015 HPK
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
	'SPECIAL_ACTIVITY_STATS_INSTALLED'				=> 'Zainstalowana wersja: v%s',

	'SPECIAL_ACTIVITY_STATS_TITLE'					=> 'Statystyki Aktywności',
	'SPECIAL_ACTIVITY_STATS_DISP_SET'				=> 'Opcje',
	'SPECIAL_ACTIVITY_STATS_OTHER'					=> 'Inne opcje',

	// acp form
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Pokaż nowe tematy',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Wyświetla liczbę nowych tematów.',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Pokaż nowe posty',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Wyświetla liczbę nowych postów.',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Pokaż nowych użytkowników',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Wyświetla liczbę nowych użytkowinków.',

	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'				=> 'Pokaż boty',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Wyświetla liczbę botów jakie odwiedziły forum.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'			=> 'Pokaż gości',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Wyświetla liczbę gości odwiedzających forum.',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'			=> 'Pokaż ukrytych użytkowników',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Wyświetla ukrytych użytkowników na liście? (konieczne uprawnienia).',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'				=> 'Pokaż czas',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'			=> 'Wyświetla czas, kiedy użytkownik był ostatni raz aktywny.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Format daty',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'				=> 'Wyświetlaj po najechaniu myszką.',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'				=> 'Pokaż IP użytkowników',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'			=> 'Tylko dla użytkowników z uprawnieniami administracyjnymi.',

	'SPECIAL_ACTIVITY_STATS_RECORD'					=> 'Pokaż rekord',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'				=> 'Wyświetla i zapamiętuje rekord.',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Format daty dla rekordu',
	'SPECIAL_ACTIVITY_STATS_RESET'					=> 'Resetuj rekord',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'				=> '',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'				=> 'Jeżeli zatwierdzisz zmiany,\nrekord zostanie zresetowany.',


	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Konfiguracja została zmieniona.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'				=> 'Sortuj użytkowników',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'			=> 'W jakiej kolejności będą wyświetlani użytkownicy?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'				=> 'Nazwa użytkownika A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'				=> 'Nazwa użytkownika Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'				=> 'Czas wizyty - rosnąco',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'				=> 'Czas wizyty - malejąco',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'				=> 'ID użytkownika - rosnąco',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'				=> 'ID użytkownika - malejjąco',

	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'				=> 'Cache (sekundy)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Okres, co ile statystyki są przeliczane (poprawia wydajność).',

	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Sprawdź uprawnienia',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'Jeżeli wybierzesz "<strong>Nie</strong>" - każdy powinien zobaczyć statystyki aktywności (ustawienia uprawnień są ignorowane). Jeżeli wybierzesz "<strong>Tak</strong>" - wykorzystane zostaną ustawienia uprawnień dla poszczególnych grup.',

	'SPECIAL_ACTIVITY_STATS_MODE'					=> 'Wyświetl użytkowników  z ...',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'				=> 'Wyświetlanie użytkowników z dzisiaj lub z okresu czasu (konfiguracja poniżej).',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'				=> 'Dzisiaj',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'			=> 'Okres czasu',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'Wpisz 0, jeżeli chcesz wyświetlić użytkowników z ostatnich 24 godzin.',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'wyłączone, jeżeli wybrałeś opcję "dzisiaj"',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'sekund',

]);
