<?php
/**
 *
 * Advanced Polls [Deutsch]
 *
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
//6
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
	'ADVANCEDPOLLS_EXT_NAME'				=> 'Advanced Polls',

// Viewtopic
	'AP_VOTES_HIDDEN'						=> 'Abstimmungen verborgen',
	'AP_POLL_RUN_TILL_APPEND'				=> ' Bis zu diesem Zeitpunkt werden alle Abstimmungen verborgen.',
	'AP_VOTERS'								=> 'Benutzer, die abgestimmt haben',
	'AP_NONE'								=> 'Keine',
	'AP_DELETED_USER'					=> 'Gelöschter Benutzer',

	'AP_POLL_CANT_VOTE'						=> 'Sie können bei dieser Umfrage nicht abstimmen. Grund',
	'AP_POLL_REASON_NOT_POSTED'				=> 'Sie haben noch keinen Beitrag in diesem Thema geschrieben.',
	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Bitte beachten Sie, falls Sie abstimmen, wird Ihre Stimme sichtbar sein.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Nicht abstimmen, Ergebnis anzeigen',
	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Bitte beachten Sie, dass die Ergebnisse nach Anzahl der abgegebenen Stimmen absteigend sortiert sind.',
	'AP_POLL_TYPE_MISMATCH'					=> 'Interner Fehler. Inkonsistente Abstimmungsdaten.',
	'AP_VOTE_CHANGED'						=> 'Sie haben nicht die Berechtigung, Ihre abgegbenen Stimmen nachträglich zu ändern.',
	'AP_TOO_MANY_VOTES'						=> 'Sie haben versucht, zuviele Stimmen abzugeben.',
	'AP_ABSTAINERS' => 'Haben auf eine Stimmabgabe verzichtet',
	'AP_DELETE_VOTE' => 'Meine Stimme löschen',

	'AP_MAX_VOTES_SELECT'					=> [
		1	=> 'Sie können bis zu <strong>%2$d</strong> Stimmen <strong>%1$d</strong>er Wahlmöglichkeit geben',
		2	=> 'Sie können bis zu <strong>%2$d</strong> Stimmen auf <strong>%1$d</strong> Wahlmöglichkeiten verteilen',
	],
	'AP_GUEST_VOTES'						=> [
		1	=> '%d Stimme von Gästen',
		2	=> '%d Stimmen von Gästen',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d Stimme',
		2 => '%d Stimmen',
	],
	'AP_SCORE_POINTS_TOTAL' => [1 => '%d Punkt', 2 => '%d Punkte'],
	'AP_SCORE_BREAKDOWN' => 'Aufschlüsselung der Stimmen',
	'AP_SCORE_AVERAGE' => 'Durchschnitt: %1$s / %2$d',
	'AP_SCORE_RATINGS' => [1 => '%d Bewertung', 2 => '%d Bewertungen'],
	'AP_SCORE_OVERALL_AVERAGE' => 'Gesamtdurchschnitt',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d Stimme mit %2$d Punkt',
		2 => '%1$d Stimmen mit %2$d Punkten',
	],
	'AP_RANK_TOTAL' => [1 => '%d Punkt', 2 => '%d Punkte'],
	'AP_RANK_BREAKDOWN' => 'Rangverteilung',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%1$d Stimme auf Position %2$d', 2 => '%1$d Stimmen auf Position %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Wählen Sie genau %d Option in der Reihenfolge Ihrer Präferenz aus.',
		2 => 'Wählen Sie genau %d Optionen in der Reihenfolge Ihrer Präferenz aus.',
	],
	'AP_POLL_LIST' => 'Umfragen',
	'AP_POLL_LIST_ALL' => 'Alle Umfragen',
	'AP_POLL_LIST_OPEN' => 'Offen',
	'AP_POLL_LIST_CLOSED' => 'Geschlossen',
	'AP_POLL_LIST_EMPTY' => 'Es wurden keine zugänglichen Umfragen gefunden.',
	'AP_POLL_LIST_VIEW' => 'Umfrage ansehen',
	'AP_POLL_LIST_ENDS' => 'Endet am %s',
	'AP_POLL_LIST_ENDED' => 'Beendet am %s',
	'AP_POLL_LIST_LEADING' => 'Führendes Ergebnis: %1$s — %2$s',
// Posting
	'AP_POLL_TYPE' => 'Umfragetyp',
	'AP_POLL_TYPE_EXPLAIN' => 'Legen Sie fest, wie Benutzer ihre Stimmen oder Punkte vergeben.',
	'AP_POLL_TYPE_CHOICE' => 'Auswahl',
	'AP_POLL_TYPE_SCORING' => 'Numerische Bewertung',
	'AP_POLL_TYPE_RANKING' => 'Geordnete Rangfolge',
	'AP_SCORE_RESULT' => 'Bewertungsergebnis',
	'AP_SCORE_RESULT_EXPLAIN' => 'Zeigt entweder die gesammelten Punkte oder den arithmetischen Mittelwert der für jede Option abgegebenen Bewertungen an.',
	'AP_SCORE_RESULT_TOTAL' => 'Gesammelte Punkte',
	'AP_SCORE_RESULT_AVERAGE' => 'Durchschnittliche Bewertung',
	'AP_POLL_SHOW_PERCENT' => 'Prozentwert anzeigen',
	'AP_POLL_SHOW_PERCENT_EXPLAIN' => 'Zeigt den Prozentwert neben jedem Ergebnisbalken. Im Durchschnittsmodus wird der Balken stets anhand der Höchstbewertung skaliert.',
	'AP_POLL_VISIBILITY' => 'Sichtbarkeit der Ergebnisse',
	'AP_POLL_VISIBILITY_EXPLAIN' => 'Wählen Sie aus, wann die Gesamtergebnisse der Umfrage sichtbar werden.',
	'AP_VISIBILITY_PUBLIC' => 'Öffentlich — Ergebnisse immer anzeigen',
	'AP_VISIBILITY_DEFAULT' => 'Nach der ersten Stimmabgabe',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Nachdem alle verfügbaren Stimmen verwendet wurden',
	'AP_VISIBILITY_PRIVATE' => 'Privat — erst nach Ende der Umfrage',
	'AP_POLL_VOTE_MODE' => 'Stimmänderungen',
	'AP_POLL_VOTE_MODE_EXPLAIN' => 'Legen Sie fest, ob Stimmen endgültig sind, schrittweise abgegeben oder während der offenen Umfrage geändert werden können.',
	'AP_VOTE_MODE_NO_CHANGE' => 'Keine Änderungen',
	'AP_VOTE_MODE_INCREMENTAL' => 'Schrittweise Abstimmung',
	'AP_VOTE_MODE_CHANGE' => 'Änderungen erlauben',
	'AP_POLL_VOTES_HIDE'					=> 'Abstimmungsergebnisse verbergen',
	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Wenn diese Option aktiviert ist, werden die Abstimmungsergebnisse verborgen, bis die Umfrage beendet ist.<br />Diese Option funktioniert nur, wenn ein Endedatum für diese Umfrage gesetzt ist.',
	'AP_POLL_VOTERS_SHOW'					=> 'Benutzer, die abgestimmt haben, anzeigen',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Wenn diese Option aktiviert ist, werden Benutzer, die abgestimmt haben, für alle mit entsprechenden Berechtigungen sichtbar sein.<br />Beachten Sie, dass diese Benutzer verborgen bleiben, falls die Abstimmungen geheim sein sollten.',
	'AP_POLL_VOTERS_LIMIT'					=> 'Umfrage einschränken',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Wenn diese Option aktiviert ist, werden Benutzer nur abstimmen können, wenn sie in diesem Thema bereits etwas geschrieben haben.',
	'AP_POLL_SHOW_ORDERED'					=> 'Ergebnisse sortiert anzeigen',
	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Wenn die Ergebnisse angezeigt werden, werden sie absteigend nach der Anzahl der erhaltenen Stimmen angezeigt (am meisten Gewähltes zuerst). Ansonsten wird die Sortierung gemäss Umfrageoption verwendet.',
	'AP_POLL_COLLAPSIBLE'					=> 'Einklappbare Umfrage',
	'AP_POLL_COLLAPSIBLE_EXPLAIN'			=> 'Erlaubt Benutzern, diese Umfrage ein- und auszuklappen.',
	'AP_COLLAPSE_POLL'						=> 'Umfrage einklappen',
	'AP_EXPAND_POLL'						=> 'Umfrage ausklappen',
	'AP_RUN_POLL'							=> 'Umfrage starten',
	'AP_RUN_POLL_FOR'						=> 'für',
	'AP_RUN_POLL_UNTIL'						=> 'bis',
	'AP_RUN_POLL_INDEFINITELY'				=> 'unendlich',
	'AP_POLL_END'							=> 'Umfrageende',
	'AP_POLL_END_EXPLAIN'					=> 'Geben Sie das Datum und die Uhrzeit an, zu denen die Umfrage beendet sein soll. Falls eines dieser Felder ausgefüllt ist, überschreibt es die Umfragedauer. Bei leerem Datumsfeld wird das aktuelle Umfrage-Endedatum verwendet; ein leeres Zeitfeld bedeutet 00:00 Uhr. Möchten Sie wieder die Umfragedauer nutzen, müssen Sie diese Felder leeren.',

	'AP_YYYY_MM_DD'							=> 'YYYY-MM-DD',
	'AP_HH_MM'								=> 'HH:MM',
	'AP_POLL_END_INVALID'					=> 'Ungültiges Datum/ ungültige Uhrzeit angegeben',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'Die maximale Anzahl Stimmen für eine Ausahlmöglichkeit kann nicht grösser sein als die Gesamtzahl aller Stimmen für alle Wahlmöglichkeiten',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'Die maximale Anzahl aller Ausahlmöglichkeiten kann nicht größer sein als die maximale Anzahl Stimmen, die auf diese Wahlmöglichkeiten verteilt werden können',

	'AP_POLL_MAX_VALUE'						=> 'Maximale Anzahl Stimmen pro Auswahlmöglichkeit',
	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Dies ist die maximale Anzahl Stimmen, die ein Benutzer einer Auswahlmöglichkeit geben kann.',
	'AP_POLL_TOTAL_VALUE'					=> 'Gesamtanzahl Stimmen',
	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Dies ist die gesamte Anzahl von Stimmen, die ein Benutzer auf alle Auswahlmöglichkeiten verteilen kann.',

	'AP_RANK_POINTS' => 'Punkte je Position',
	'AP_RANK_POINTS_EXPLAIN' => 'Legen Sie für jede Rangposition einen positiven, abnehmenden Punktwert fest. Die Anzahl der Positionen wird durch die maximalen Optionen pro Benutzer bestimmt.',
	'AP_RANK_POSITION' => 'Position %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Sie können nicht mehr Stimmen vergeben, als maximal erlaubt sind.',
	'AP_POLL_VALUES_INVALID' => 'Die Mindestpunktzahl darf die Höchstpunktzahl nicht überschreiten; maximale Optionen, Höchstpunktzahl und Gesamtpunktzahl müssen größer als null sein.',
	'AP_RANK_POSITIONS_INVALID' => 'Die Anzahl der Rangpositionen muss zwischen 1 und der Anzahl der Umfrageoptionen liegen.',
	'AP_RANK_POINTS_INCOMPLETE' => 'Legen Sie für jede Rangposition einen Punktwert fest.',
	'AP_RANK_POINTS_INVALID' => 'Jeder Rangpunktwert muss zwischen 1 und 999 liegen.',
	'AP_RANK_POINTS_ORDER' => 'Die Rangpunktwerte müssen von der ersten bis zur letzten Position strikt abnehmen.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'Inkrementelles Abstimmen kann nicht mit einer geordneten Rangfolge verwendet werden.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'Wählen Sie genau die konfigurierte Anzahl von Optionen in der Reihenfolge Ihrer Präferenz aus.',
	'AP_QUESTION' => 'Frage',
	'AP_QUESTION_REQUIRED' => 'Pflichtfrage',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'Fordert eine Antwort auf die erste Frage, bevor der vollständige Stimmzettel abgesendet werden kann.',
	'AP_APPEND_OPTIONS' => 'Optionen hinzufügen, ohne Stimmen zurückzusetzen',
	'AP_APPEND_OPTIONS_EXPLAIN' => 'Behält alle vorhandenen Stimmen bei und fügt nur neue Optionen am Ende der Optionsliste einer Frage hinzu.',
	'AP_APPEND_OPTIONS_WARNING' => 'Vorhandene Fragen und Optionen dürfen nicht umbenannt, entfernt oder neu angeordnet werden. Stimmänderungen müssen erlaubt sein. Berechtigte registrierte Abstimmende werden gemäß der ACP-Einstellung und ihren Benachrichtigungseinstellungen informiert.',
	'AP_APPEND_INVALID' => 'Dieser Umfrage können Optionen nicht sicher hinzugefügt werden.',
	'AP_APPEND_REQUIRES_CHANGES' => 'Erlauben Sie Stimmänderungen, bevor Optionen hinzugefügt werden, ohne vorhandene Stimmen zurückzusetzen.',
	'AP_APPEND_POLL_ENDED' => 'Nach dem Ende der Umfrage können keine Optionen hinzugefügt werden, ohne Stimmen zurückzusetzen.',
	'AP_APPEND_STRUCTURE_CHANGED' => 'Vorhandene Fragen oder Optionen wurden geändert. Stellen Sie die ursprüngliche Definition wieder her und fügen Sie neue Optionen nur am Ende hinzu.',
	'AP_APPEND_TOO_MANY' => 'Die hinzugefügten Optionen überschreiten die konfigurierte Höchstzahl an Umfrageoptionen.',
	'AP_APPEND_NONE' => 'Es wurden keine neuen Umfrageoptionen hinzugefügt.',
	'AP_ADDITIONAL_QUESTIONS' => 'Zusätzliche Frageseiten',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => 'Jede Seite verwendet denselben Umfragetyp sowie dieselben Begrenzungen, Punkte-, Sichtbarkeits- und Stimmänderungsregeln. Geben Sie eine Option pro Zeile ein.',
	'AP_ADD_QUESTION' => 'Frage hinzufügen',
	'AP_MULTI_INVALID' => 'Die Daten der zusätzlichen Fragen sind ungültig.',
	'AP_MULTI_TOO_MANY' => 'Eine Umfrage darf höchstens 20 zusätzliche Fragen enthalten.',
	'AP_MULTI_CONTENT_INVALID' => 'Jede zusätzliche Frage benötigt einen Titel und genügend gültige Optionen für die globalen Umfragebegrenzungen.',
	'AP_REQUIRED_QUESTION_MISSING' => 'Beantworten Sie diese Pflichtfrage, bevor Sie fortfahren.',
	'AP_POLL_NAVIGATION' => 'Navigation durch die Umfragefragen',
	'AP_POLL_MIN_VALUE' => 'Mindestpunktzahl',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'Dies ist die niedrigste Punktzahl, die ein Abstimmender einer ausgewählten Option zuweisen darf.',
	'AP_VOTE_OUTSIDE_RANGE' => 'Jede vergebene Punktzahl muss zwischen dem festgelegten Mindest- und Höchstwert liegen.',
]);
