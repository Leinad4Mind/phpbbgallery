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
	'CONTEST_RATING_HIDDEN' => 'verborgen',
	'CONTEST_RESULT_HIDDEN' => 'De beoordelingen van deze afbeeldingen zijn verborgen tot de wedstrijd eindigt op %s.',
	'CONTEST_COMMENTS_STARTS' => 'Reacties op afbeeldingen in deze wedstrijd zijn toegestaan vanaf %s.',
	'CONTEST_ENDED'           => 'Deze wedstrijd is geëindigd op %s.',
	'CONTEST_ENDS'            => 'Deze wedstrijd eindigt op %s.',
	'CONTEST_RATING_STARTED'  => 'De beoordelingsronde voor deze wedstrijd is begonnen op %s.',
	'CONTEST_RATING_STARTS'   => 'De beoordelingsronde voor deze wedstrijd begint op %s.',
	'CONTEST_RESULT'          => 'Wedstrijd',
	'CONTEST_RESULT_1'        => 'Winnaar',
	'CONTEST_RESULT_2'        => 'Tweede',
	'CONTEST_RESULT_3'        => 'Derde',
	'CONTEST_STARTED'         => 'Deze wedstrijd is begonnen op %s.',
	'CONTEST_STARTS'          => 'Deze wedstrijd begint op %s.',
	'CONTEST_USERNAME'        => '<strong>Wedstrijd</strong>',
	'CONTEST_IMAGE_DESC'      => '<strong>Wedstrijd</strong> » De afbeeldingsomschrijving is verborgen tot de wedsteijd eindigt op %s.',
	'CONTEST_WINNERS_OF'      => 'Winnaars van de wedstrijd “%s”',
	'SEARCH_CONTEST'                    => 'Winnaars',
	'VIEW_SEARCH_CONTESTS'  => 'Wedstrijdwinnaars bekijken',
	'CONTEST_STATUS' => 'Wedstrijdstatus',
	'CONTEST_PHASE_UPCOMING' => 'Gepland',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Inzendingen openen op %s.',
	'CONTEST_PHASE_UPLOAD' => 'Inzendingen geopend',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'Afbeeldingen kunnen worden ingezonden tot %s. Stemmen en reacties zijn nog niet beschikbaar.',
	'CONTEST_PHASE_RATING' => 'Stemmen geopend',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Inzendingen zijn gesloten. Stemmen blijft mogelijk tot %s; reacties worden daarna geopend.',
	'CONTEST_PHASE_FINISHED' => 'Beëindigd',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'De wedstrijd is beëindigd. Resultaten en reacties zijn nu beschikbaar.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'Tijden worden in jouw tijdzone weergegeven: %s.',
]);
