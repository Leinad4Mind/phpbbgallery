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
	'CONTEST_RATING_HIDDEN' => 'nascosto',
	'CONTEST_RESULT_HIDDEN' => 'La valutazione per questa immagine è nascosta fino alla fine del concorso il %s.',
	'CONTEST_COMMENTS_STARTS' => 'I commenti sulle immagini in questo concorso sono permessi dal %s in avanti.',
	'CONTEST_ENDED'           => 'Questo concorso è terminato il %s.',
	'CONTEST_ENDS'            => 'Questo concorso termina il %s.',
	'CONTEST_RATING_STARTED'  => 'La valutazione per questo concorso è iniziata il %s.',
	'CONTEST_RATING_STARTS'   => 'La valutazione per questo concorso inizia il %s.',
	'CONTEST_RESULT'          => 'Concorso',
	'CONTEST_RESULT_1'        => 'Vincitore',
	'CONTEST_RESULT_2'        => 'Secondo',
	'CONTEST_RESULT_3'        => 'Terzo',
	'CONTEST_STARTED'         => 'Il concorso è iniziato il %s.',
	'CONTEST_STARTS'          => 'Il concorso inizia il %s.',
	'CONTEST_USERNAME'        => '<strong>Concorso</strong>',
	'CONTEST_IMAGE_DESC'      => '<strong>Concorso</strong> » La descrizione dell’immagine è nascosta, fino alla fine del concorso il %s.',
	'CONTEST_WINNERS_OF'      => 'Vincitori del concorso “%s”',
	'SEARCH_CONTEST'                    => 'Vincitori del concorso',
	'VIEW_SEARCH_CONTESTS'  => 'Visualizza i vincitori dei concorsi',
	'CONTEST_STATUS' => 'Stato del concorso',
	'CONTEST_PHASE_UPCOMING' => 'Programmato',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Le candidature si aprono il %s.',
	'CONTEST_PHASE_UPLOAD' => 'Candidature aperte',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'Le immagini possono essere inviate fino al %s. Votazioni e commenti non sono ancora disponibili.',
	'CONTEST_PHASE_RATING' => 'Votazioni aperte',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Le candidature sono chiuse. Le votazioni restano aperte fino al %s; i commenti saranno disponibili dopo.',
	'CONTEST_PHASE_FINISHED' => 'Terminato',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'Il concorso è terminato. Risultati e commenti sono ora disponibili.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'Le date sono mostrate nel tuo fuso orario: %s.',
]);
