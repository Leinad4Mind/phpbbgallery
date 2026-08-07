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
	'ADVANCEDPOLLS_EXT_NAME'				=> 'Zaawansowane głosowanie',

// Viewtopic
	'AP_VOTES_HIDDEN'						=> 'Ukryte głosy',
	'AP_POLL_RUN_TILL_APPEND'				=> ', do tej pory wszystkie głosy będą ukryte.',
	'AP_VOTERS'								=> 'Głosujący',
	'AP_NONE'								=> 'Brak',
	'AP_DELETED_USER'					=> 'Usunięty użytkownik',

	'AP_POLL_CANT_VOTE'						=> 'Nie możesz głosować w tej ankiecie. Powód',
	'AP_POLL_REASON_NOT_POSTED'				=> 'nie pisałeś w tym wątku.',
	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Jeśli głosujesz, Twój głos będzie widoczny.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Nie głosuj, zobacz wyniki, ale stracisz prawo do głosowania',
	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Wyniki są ułożone według malejącej ilości otrzymanych głosów.',
	'AP_POLL_TYPE_MISMATCH'					=> 'Niespójne dane ankiety, błąd wewnętrzny.',
	'AP_VOTE_CHANGED'						=> 'Nie masz uprawnień do zmiany oddanych głosów.',
	'AP_TOO_MANY_VOTES'						=> 'Próbowałeś oddać zbyt wiele głosów.',
	'AP_ABSTAINERS' => 'Wybrali brak głosu',
	'AP_DELETE_VOTE' => 'Usuń mój głos',

	'AP_MAX_VOTES_SELECT'					=> [
		1	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głos na <strong>%1$d</strong> opcję',
		2	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głosów wśród <strong>%1$d</strong> opcji',
	],
	'AP_GUEST_VOTES'						=> [
		1	=> '%d głos od Gościa',
		2	=> '%d głosy od Gości',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d głos',
		2 => '%d głosy',
		3 => '%d głosów',
	],
	'AP_SCORE_POINTS_TOTAL' => [1 => '%d punkt', 2 => '%d punkty'],
	'AP_SCORE_BREAKDOWN' => 'Rozkład głosów',
	'AP_SCORE_AVERAGE' => 'Średnia: %1$s / %2$d',
	'AP_SCORE_RATINGS' => [1 => '%d ocena', 2 => '%d oceny'],
	'AP_SCORE_OVERALL_AVERAGE' => 'Średnia ogólna',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d głos o wartości %2$d punktu',
		2 => '%1$d głosy o wartości %2$d punktów',
		3 => '%1$d głosów o wartości %2$d punktów',
	],
	'AP_RANK_TOTAL' => [1 => '%d punkt', 2 => '%d punkty'],
	'AP_RANK_BREAKDOWN' => 'Rozkład rankingu',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%1$d głos na pozycji %2$d', 2 => '%1$d głosy na pozycji %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Wybierz dokładnie %d opcję w kolejności preferencji.',
		2 => 'Wybierz dokładnie %d opcje w kolejności preferencji.',
	],
	'AP_POLL_LIST' => 'Ankiety',
	'AP_POLL_LIST_ALL' => 'Wszystkie ankiety',
	'AP_POLL_LIST_OPEN' => 'Otwarte',
	'AP_POLL_LIST_CLOSED' => 'Zamknięte',
	'AP_POLL_LIST_EMPTY' => 'Nie znaleziono dostępnych ankiet.',
	'AP_POLL_LIST_VIEW' => 'Zobacz ankietę',
	'AP_POLL_LIST_ENDS' => 'Kończy się %s',
	'AP_POLL_LIST_ENDED' => 'Zakończono %s',
	'AP_POLL_LIST_LEADING' => 'Prowadzący wynik: %1$s — %2$s',
// Posting
	'AP_POLL_TYPE' => 'Typ ankiety',
	'AP_POLL_TYPE_EXPLAIN' => 'Wybierz sposób przydzielania głosów lub punktów przez użytkowników.',
	'AP_POLL_TYPE_CHOICE' => 'Wybór',
	'AP_POLL_TYPE_SCORING' => 'Ocena liczbowa',
	'AP_POLL_TYPE_RANKING' => 'Ranking uporządkowany',
	'AP_SCORE_RESULT' => 'Wynik punktacji',
	'AP_SCORE_RESULT_EXPLAIN' => 'Wyświetla sumę punktów albo średnią arytmetyczną ocen oddanych na każdą opcję.',
	'AP_SCORE_RESULT_TOTAL' => 'Suma punktów',
	'AP_SCORE_RESULT_AVERAGE' => 'Średnia ocena',
	'AP_POLL_SHOW_PERCENT' => 'Pokaż procent',
	'AP_POLL_SHOW_PERCENT_EXPLAIN' => 'Pokazuje procent obok każdego paska wyniku. W trybie średniej pasek jest zawsze skalowany względem maksymalnej oceny.',
	'AP_POLL_VISIBILITY' => 'Widoczność wyników',
	'AP_POLL_VISIBILITY_EXPLAIN' => 'Wybierz, kiedy zbiorcze wyniki ankiety będą widoczne.',
	'AP_VISIBILITY_PUBLIC' => 'Publiczne — zawsze pokazuj wyniki',
	'AP_VISIBILITY_DEFAULT' => 'Po pierwszym głosie',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Po wykorzystaniu wszystkich dostępnych głosów',
	'AP_VISIBILITY_PRIVATE' => 'Prywatne — dopiero po zakończeniu ankiety',
	'AP_POLL_VOTE_MODE' => 'Zmiana głosów',
	'AP_POLL_VOTE_MODE_EXPLAIN' => 'Wybierz, czy głosy są ostateczne, mogą być oddawane stopniowo lub zmieniane, dopóki ankieta jest otwarta.',
	'AP_VOTE_MODE_NO_CHANGE' => 'Bez zmian',
	'AP_VOTE_MODE_INCREMENTAL' => 'Głosowanie stopniowe',
	'AP_VOTE_MODE_CHANGE' => 'Zezwól na zmiany',
	'AP_POLL_VOTES_HIDE'					=> 'Ukryj głosy',
	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Jeśli włączone, głosy będą ukryte do końca głosowania. Ta opcja działa jeśli jest wyznaczony koniec ankiety.',
	'AP_POLL_VOTERS_SHOW'					=> 'Pokaż głosy głosujących',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Jeśli włączone, głosujący będą pokazani tym użytkownikom, którzy mają uprawnienia. Głosujący pozostaną ukryci jeśli głosy są ukryte.',
	'AP_POLL_VOTERS_LIMIT'					=> 'Ograniczenie głosów',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Jeśli włączone, użytkownicy mogą głosować tylko wtedy gdy pisali w tym wątku.',
	'AP_POLL_SHOW_ORDERED'					=> 'Pokaż kolejność wyników',
	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Wyświetlane wyniki są uporządkowane według malejącej liczby otrzymanych głosów (najpierw najwięcej głosów). W przeciwnym razie używana jest kolejność opcji ankiety.',
	'AP_POLL_COLLAPSIBLE'					=> 'Zwijalna ankieta',
	'AP_POLL_COLLAPSIBLE_EXPLAIN'			=> 'Pozwala użytkownikom zwijać i rozwijać tę ankietę.',
	'AP_COLLAPSE_POLL'						=> 'Zwiń ankietę',
	'AP_EXPAND_POLL'						=> 'Rozwiń ankietę',
	'AP_RUN_POLL'							=> 'Uruchom ankietę',
	'AP_RUN_POLL_FOR'						=> 'przez',
	'AP_RUN_POLL_UNTIL'						=> 'aż do',
	'AP_RUN_POLL_INDEFINITELY'				=> 'bez końca',
	'AP_POLL_END'							=> 'koniec ankiety',
	'AP_POLL_END_EXPLAIN'					=> 'Określ datę i godzinę zakończenia ankiety. Jeśli którekolwiek z tych pól jest określone, zastępuje ono długość ankiety. Pola daty domyślnie pozostawiono puste, domyślnie bieżąca data zakończenia ankiety; pola godzin pozostawione puste, domyślnie ustawione na 0. Jeśli chcesz powrócić do korzystania z długości ankiety, będziesz musiał wyczyścić wszystkie te pola.',

	'AP_YYYY_MM_DD'							=> 'YYYY-MM-DD',
	'AP_HH_MM'								=> 'HH:MM',
	'AP_POLL_END_INVALID'					=> 'Określona data/czas są niewłaściwe',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'Maksymalna liczba głosów przypadająca na jedną opcję nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'Maksymalna liczba opcji głosowania nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',

	'AP_POLL_MAX_VALUE'						=> 'Maksymalna liczba głosów',
	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'To jest maksymalna liczba głosów, jaką głosujący może oddać na jedną opcję.',
	'AP_POLL_TOTAL_VALUE'					=> 'Razem głosów',
	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'To jest całkowita liczba głosów, jaką głosujący może rozdzielić na wszystkie opcje.',

	'AP_RANK_POINTS' => 'Punkty według pozycji',
	'AP_RANK_POINTS_EXPLAIN' => 'Ustaw dodatnią, malejącą wartość punktową dla każdej pozycji. Liczbę pozycji określa maksymalna liczba opcji na użytkownika.',
	'AP_RANK_POSITION' => 'Pozycja %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Nie możesz przydzielić liczby głosów większej niż maksymalna dozwolona wartość.',
	'AP_POLL_VALUES_INVALID' => 'Minimalna ocena nie może przekraczać maksymalnej; maksymalna liczba opcji, maksymalna ocena i łączna ocena muszą być większe od zera.',
	'AP_RANK_POSITIONS_INVALID' => 'Liczba pozycji musi mieścić się między 1 a liczbą opcji ankiety.',
	'AP_RANK_POINTS_INCOMPLETE' => 'Określ wartość punktową dla każdej pozycji.',
	'AP_RANK_POINTS_INVALID' => 'Każda wartość punktowa musi mieścić się między 1 a 999.',
	'AP_RANK_POINTS_ORDER' => 'Punkty muszą ściśle maleć od pierwszej do ostatniej pozycji.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'Głosowanie przyrostowe nie może być używane z rankingiem uporządkowanym.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'Wybierz dokładnie skonfigurowaną liczbę opcji w kolejności preferencji.',
	'AP_QUESTION' => 'Pytanie',
	'AP_QUESTION_REQUIRED' => 'Pytanie obowiązkowe',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'Wymaga odpowiedzi na pierwsze pytanie przed wysłaniem całego formularza głosowania.',
	'AP_APPEND_OPTIONS' => 'Dodaj opcje bez resetowania głosów',
	'AP_APPEND_OPTIONS_EXPLAIN' => 'Zachowuje wszystkie istniejące głosy i dodaje wyłącznie nowe opcje na końcu listy opcji pytania.',
	'AP_APPEND_OPTIONS_WARNING' => 'Nie wolno zmieniać nazw, usuwać ani przestawiać istniejących pytań i opcji. Zmiana głosu musi być dozwolona. Uprawnieni zarejestrowani użytkownicy, którzy wcześniej głosowali, zostaną powiadomieni zgodnie z ustawieniem ACP i własnymi preferencjami powiadomień.',
	'AP_APPEND_INVALID' => 'Nie można bezpiecznie dodać opcji do tej ankiety.',
	'AP_APPEND_REQUIRES_CHANGES' => 'Zezwól na zmianę głosu przed dodaniem opcji bez resetowania istniejących głosów.',
	'AP_APPEND_POLL_ENDED' => 'Po zakończeniu ankiety nie można dodać opcji bez resetowania głosów.',
	'AP_APPEND_STRUCTURE_CHANGED' => 'Zmieniono istniejące pytania lub opcje. Przywróć pierwotną definicję i dodaj nowe opcje wyłącznie na końcu.',
	'AP_APPEND_TOO_MANY' => 'Dodane opcje przekraczają skonfigurowaną maksymalną liczbę opcji ankiety.',
	'AP_APPEND_NONE' => 'Nie dodano żadnych nowych opcji ankiety.',
	'AP_ADDITIONAL_QUESTIONS' => 'Dodatkowe strony pytań',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => 'Każda strona używa tego samego typu ankiety oraz tych samych limitów i zasad punktacji, widoczności i zmiany głosu. Wpisz jedną opcję w każdym wierszu.',
	'AP_ADD_QUESTION' => 'Dodaj pytanie',
	'AP_MULTI_INVALID' => 'Dane dodatkowych pytań są nieprawidłowe.',
	'AP_MULTI_TOO_MANY' => 'Ankieta może zawierać najwyżej 20 dodatkowych pytań.',
	'AP_MULTI_CONTENT_INVALID' => 'Każde dodatkowe pytanie wymaga tytułu i wystarczającej liczby prawidłowych opcji dla globalnych limitów ankiety.',
	'AP_REQUIRED_QUESTION_MISSING' => 'Odpowiedz na to obowiązkowe pytanie przed kontynuowaniem.',
	'AP_POLL_NAVIGATION' => 'Nawigacja po pytaniach ankiety',
	'AP_POLL_MIN_VALUE' => 'Minimalna punktacja',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'To najniższa punktacja, jaką głosujący może przyznać wybranej opcji.',
	'AP_VOTE_OUTSIDE_RANGE' => 'Każda przyznana punktacja musi mieścić się między ustawioną wartością minimalną i maksymalną.',
]);
