<?php
/**
 * phpBB Gallery Contest frontend language.
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
	'CONTEST_RATING_HIDDEN' => 'versteckt',
	'CONTEST_RESULT_HIDDEN' => 'Die Bewertung des Bildes ist bis zum Ende des Wettbewerbs am %s versteckt.',
	'CONTEST_COMMENTS_STARTS' => 'Kommentare sind auf Grund des Wettbewerbs erst ab dem %s erlaubt.',
	'CONTEST_ENDED'           => 'Dieser Wettbewerb endete am %s.',
	'CONTEST_ENDS'            => 'Dieser Wettbewerb endet am %s.',
	'CONTEST_RATING_STARTED'  => 'Die Bewertung für diesen Wettbewerb begann am %s.',
	'CONTEST_RATING_STARTS'   => 'Die Bewertung für diesen Wettbewerb beginnt am %s.',
	'CONTEST_RESULT'          => 'Wettbewerb',
	'CONTEST_RESULT_1'        => 'Sieger',
	'CONTEST_RESULT_2'        => 'Zweiter',
	'CONTEST_RESULT_3'        => 'Dritter',
	'CONTEST_STARTED'         => 'Der Wettbewerb begann am %s.',
	'CONTEST_STARTS'          => 'Der Wettbewerb beginnt am %s.',
	'CONTEST_USERNAME'        => '<strong>Wettbewerb</strong>',
	'CONTEST_IMAGE_DESC'      => '<strong>Wettbewerb</strong> » Die Beschreibung wird bis zum Ende des Wettbewerbs am %s versteckt.',
	'CONTEST_WINNERS_OF'      => 'Gewinner des Wettbewerbs „%s“',
	'SEARCH_CONTEST'                    => 'Wettbewerb-Sieger',
	'VIEW_SEARCH_CONTESTS'  => 'Wettbewerbsgewinner anzeigen',
	'CONTEST_STATUS' => 'Wettbewerbsstatus',
	'CONTEST_PHASE_UPCOMING' => 'Geplant',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Einreichungen beginnen am %s.',
	'CONTEST_PHASE_UPLOAD' => 'Einreichungen geöffnet',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'Bilder können bis %s eingereicht werden. Abstimmungen und Kommentare sind noch nicht verfügbar.',
	'CONTEST_PHASE_RATING' => 'Abstimmung geöffnet',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Einreichungen sind geschlossen. Die Abstimmung bleibt bis %s geöffnet; Kommentare sind danach möglich.',
	'CONTEST_PHASE_FINISHED' => 'Beendet',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'Der Wettbewerb ist beendet. Ergebnisse und Kommentare sind jetzt verfügbar.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'Zeiten werden in Ihrer Zeitzone angezeigt: %s.',
]);
