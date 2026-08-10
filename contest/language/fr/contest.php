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
	'CONTEST_RATING_HIDDEN' => 'Cachée',
	'CONTEST_RESULT_HIDDEN' => 'La note de cette image est cachée jusqu’à la fin du concours le %s.',
	'CONTEST_COMMENTS_STARTS' => 'Les commentaires sur les images de ce concours sont autorisés à partir du %s.',
	'CONTEST_ENDED'           => 'Ce concours s’est terminé le %s.',
	'CONTEST_ENDS'            => 'Ce concours se termine le %s.',
	'CONTEST_RATING_STARTED'  => 'Les votes du concours ont débuté le %s.',
	'CONTEST_RATING_STARTS'   => 'Les votes du concours débutent le %s.',
	'CONTEST_RESULT'          => 'Concours',
	'CONTEST_RESULT_1'        => 'Vainqueur',
	'CONTEST_RESULT_2'        => 'Deuxième',
	'CONTEST_RESULT_3'        => 'Troisième',
	'CONTEST_STARTED'         => 'Le concours a débuté le %s.',
	'CONTEST_STARTS'          => 'Le concours débute le %s.',
	'CONTEST_USERNAME'        => '<strong>Concours</strong>',
	'CONTEST_IMAGE_DESC'      => '<strong>Concours</strong> » La description de l’image est cachée, jusqu’à la fin du concours le %s.',
	'CONTEST_WINNERS_OF'      => 'Vainqueurs du concours « %s »',
	'SEARCH_CONTEST'                    => 'Vainqueurs du concours',
	'VIEW_SEARCH_CONTESTS'  => 'Voir les vainqueurs des concours',
	'CONTEST_STATUS' => 'Statut du concours',
	'CONTEST_PHASE_UPCOMING' => 'Planifié',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Les participations ouvriront le %s.',
	'CONTEST_PHASE_UPLOAD' => 'Participations ouvertes',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'Les images peuvent être envoyées jusqu’au %s. Le vote et les commentaires ne sont pas encore disponibles.',
	'CONTEST_PHASE_RATING' => 'Vote ouvert',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Les participations sont closes. Le vote reste ouvert jusqu’au %s ; les commentaires ouvriront ensuite.',
	'CONTEST_PHASE_FINISHED' => 'Terminé',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'Le concours est terminé. Les résultats et les commentaires sont maintenant disponibles.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'Les dates sont affichées dans votre fuseau horaire : %s.',
]);
