<?php
/**
 *
 * Advanced Polls [Polish]
 * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
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
	'AP_TITLE_ACP'					=> 'Zaawansowane głosowanie',
	'AP_SETTINGS_ACP'				=> 'Ustawienia',

	'AP_TITLE'						=> 'Zaawansowane głosowanie',
	'AP_TITLE_EXPLAIN'				=> 'Zaawansowane głosowanie to podstawowy system ankiet phpBB z nowymi funkcjami, takimi jak ukrywanie głosów do końca, pokazywanie wyborców, ograniczanie głosów i nie tylko.',

	'AP_SETTINGS'					=> 'Zaawansowane głosowanie - Ustawienia',
	'AP_GLOBAL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia ogólne (zastosowanie do wszystkich ankiet)',
	'AP_PER_POLL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia poszczególnych ankiet (do wyboru w każdej ankiecie, z ustawioną tutaj wartością domyślną)',
	'AP_DEFAULT_POLL_VISIBILITY' => 'Domyślna widoczność wyników',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'Tryb widoczności początkowo wybrany podczas tworzenia ankiety.',
	'AP_DEFAULT_POLL_VOTE_MODE' => 'Domyślny tryb zmiany głosu',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN' => 'Tryb zmiany głosu początkowo wybrany podczas tworzenia ankiety.',
	'AP_VISIBILITY_PUBLIC' => 'Publiczne — zawsze pokazuj wyniki',
	'AP_VISIBILITY_DEFAULT' => 'Po pierwszym głosie',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Po wykorzystaniu wszystkich dostępnych głosów',
	'AP_VISIBILITY_PRIVATE' => 'Prywatne — dopiero po zakończeniu ankiety',
	'AP_VOTE_MODE_NO_CHANGE' => 'Bez zmian',
	'AP_VOTE_MODE_INCREMENTAL' => 'Głosowanie stopniowe',
	'AP_VOTE_MODE_CHANGE' => 'Zezwól na zmiany',

	'AP_ACT_VOTES_HIDE'				=> 'Pokazuj głosy',
	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Wybierz tę opcję, żeby ukryć oddane głosy do końca głosowania.',
	'AP_ACT_VOTERS_SHOW'			=> 'Pokazuj głosujących',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Wybierz tę opcję, żeby pokazać głosujących przy każdej opcji głosowania.',
	'AP_ACT_VOTERS_LIMIT'			=> 'Ogranicz liczkę głosujących',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Wybierz tę opcję, żeby ograniczyć głosujących do użytkowników piszących w tym wątku.',
	'AP_ACT_POLL_NO_VOTE'			=> 'Pokazuj Brak głosu',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Zmienia standardowy link „Wyświetl wyniki” na link „Nie głosuj, wyświetl wyniki”, który nie zezwala na głosowanie po wyświetleniu wyników, chyba że wybrano opcję „Zmień głosy”.',
	'AP_ACT_SHOW_ABSTAINERS' => 'Pokaż liczbę wstrzymujących się',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN' => 'Pokazuje liczbę zarejestrowanych użytkowników, którzy wyraźnie zrezygnowali z głosowania. Nazwy są widoczne tylko wtedy, gdy lista głosujących jest włączona i użytkownik ma uprawnienie.',
	'AP_ACT_VOTE_DELETE' => 'Zezwól na usunięcie głosu',
	'AP_ACT_VOTE_DELETE_EXPLAIN' => 'Pozwala zarejestrowanym użytkownikom usunąć własny głos, gdy ankieta jest otwarta i zezwala na zmiany.',
	'AP_ACT_SHOW_ORDERED'			=> 'Pokazuj kolejność',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Aktywuje opcję pokazania wyników w kolejności malejącej liczby otrzymanych głosów (najpierw głosowano najwyżej).',
	'AP_ACT_POLL_SCORING'			=> 'Pokazuj przewijanie głosowania',
	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Aktywuje możliwość przypisywania różnych wyników do opcji ankiety.',
	'AP_ACT_INCREMENTAL_VOTES'		=> 'Pokazuj stopniowanie głosów',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Aktywuje możliwość głosowania stopniowego, gdy nie wyczerpałeś dostępnych możliwości głosowania.',
	'AP_ACT_CLOSED_VOTING'			=> 'Pozwalaj na głosowanie zamknięte',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Włącza możliwość głosowania w otwartej ankiecie, nawet jeśli odpowiedni temat jest zablokowany.',
	'AP_ACT_POLL_END'				=> 'Pokazuj dokładny koniec ankiety',
	'AP_ACT_POLL_END_EXPLAIN'		=> 'Pozwala określić, kiedy ankieta kończy się według daty / godziny, zamiast tylko określać czas trwania ankiety od jej rozpoczęcia.',
	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Pokazuj powiadomienia ankiety',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Włącza powiadomienia, gdy wyniki ukrytej ankiety stają się widoczne oraz gdy do ankiety, w której użytkownik głosował, zostają dodane nowe opcje.',
	'AP_ACT_POLL_COLLAPSIBLE'				=> 'Włącz zwijalne ankiety',
	'AP_ACT_POLL_COLLAPSIBLE_EXPLAIN'		=> 'Wyświetla opcję zwijania podczas tworzenia lub edytowania ankiety. Przy instalacji ustawienie jest automatycznie włączane, jeśli zainstalowano „Collapsible Forum Categories”; administratorzy mogą je zawsze zmienić.',

	'AP_DEFAULT_VOTES_CHANGE'		=> 'Wybierz domyślne ustawienia zmiany oddanego głosu',
	'AP_DEFAULT_VOTES_HIDE'			=> 'Wybierz domyślne ustawienia ukrytych głosujących',
	'AP_DEFAULT_VOTERS_SHOW'		=> 'Wybierz domyślne ustawienia ilości głosujących',
	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Wybierz domyślne ustawienia limitu głosujących',
	'AP_DEFAULT_SHOW_ORDERED'		=> 'Wybierz domyślne dla pokazania kolejności',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>Następne kroki</strong></p><ol><li>Sprawdź ustawienia rozszerzenia w <strong>%1$s » %2$s » %3$s</strong> i skonfiguruj funkcje ankiet oraz wartości domyślne wymagane przez forum.</li><li>Sprawdź uprawnienia <strong>%8$s</strong> i <strong>%9$s</strong> w <strong>%4$s » %5$s » %6$s</strong> (użytkownicy) oraz <strong>%4$s » %5$s » %7$s</strong> (moderatorzy). Nadaj je wyłącznie rolom lub grupom, które mogą widzieć tożsamość głosujących.</li></ol><p>Pozostałe funkcje ankiet nie wymagają dodatkowej konfiguracji.</p></div>',
]);
