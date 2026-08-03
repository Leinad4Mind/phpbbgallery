<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ALBUM_TYPE_CONTEST'                  => 'Wettbewerb',
	'CONTEST_CREATION'                    => 'Neue Wettbewerbe erlauben',
	'CONTEST_CREATION_EXPLAIN'            => 'Erlaubt Administratoren, neue Wettbewerbsalben zu erstellen. Bestehende Wettbewerbe bleiben aktiv und bearbeitbar, wenn diese Option deaktiviert ist.',
	'CONTEST_CREATION_DISABLED'           => 'Das Erstellen neuer Wettbewerbsalben ist in der Galerie-Konfiguration deaktiviert.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Ein Album ohne Wettbewerb kann nicht in ein Album mit Wettbewerb geändert werden.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Ein Album mit Wettbewerb kann nicht in ein Album ohne Wettbewerb geändert werden.',
	'CONTEST_DATE_EXPLAIN'                => 'Das Datum bitte im Format JJJJ-MM-TT SS:MM angeben.',
	'CONTEST_END'                         => 'Ende des Wettbewerbs',
	'CONTEST_END_BEFORE_RATING'           => 'Das Ende des Wettbewerbs darf nicht vor dem Beginn der Bewertungen liegen.',
	'CONTEST_END_BEFORE_START'            => 'Das Ende des Wettbewerbs darf nicht vor dem Beginn des Wettbewerbs liegen.',
	'CONTEST_END_EXPLAIN'                 => 'Nach dem Ende des Wettbewerbs dürfen Benutzer keine Bilder mehr bewerten.',
	'CONTEST_END_INVALID'                 => 'Ungültiges Ende des Wettbewerbs (%s). Das Datum bitte im Format JJJJ-MM-TT SS:MM angeben.',
	'CONTEST_RATING'                      => 'Beginn der Bewertung des Wettbewerbs',
	'CONTEST_RATING_BEFORE_START'         => 'Der Beginn der Bewertung des Wettbewerbs darf nicht vor dem Beginn des Wettbewerbs liegen.',
	'CONTEST_RATING_EXPLAIN'              => 'Nach dem Beginn der Bewertungen dürfen Benutzer keine Bilder mehr hochladen.',
	'CONTEST_RATING_INVALID'              => 'Ungültiger Beginn der Bewertung (%s). Das Datum bitte im Format JJJJ-MM-TT SS:MM angeben.',
	'CONTEST_SETTINGS'                    => 'Wettbewerbs Einstellungen',
	'CONTEST_START'                       => 'Beginn des Wettbewerbs',
	'CONTEST_START_EXPLAIN'               => 'Ab dem Beginn des Wettbewerbs dürfen Benutzer Bilder hochladen.',
	'CONTEST_START_INVALID'               => 'Ungültiger Beginn des Wettbewerbs (%s). Das Datum bitte im Format JJJJ-MM-TT SS:MM angeben.',
]);
