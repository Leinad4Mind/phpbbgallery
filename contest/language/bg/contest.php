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
	'CONTEST_RATING_HIDDEN' => 'hidden',
	'CONTEST_RESULT_HIDDEN' => 'The rating for this images is hidden, until the end of the contest on %s.',
	'CONTEST_COMMENTS_STARTS' => 'Comments on images in this contest are allowed from %s on.',
	'CONTEST_ENDED'           => 'This contest ended on %s.',
	'CONTEST_ENDS'            => 'This contest ends on %s.',
	'CONTEST_RATING_STARTED'  => 'The rating for this contest started on %s.',
	'CONTEST_RATING_STARTS'   => 'The rating for this contest starts on %s.',
	'CONTEST_RESULT'          => 'Contest',
	'CONTEST_RESULT_1'        => 'Winner',
	'CONTEST_RESULT_2'        => 'Second',
	'CONTEST_RESULT_3'        => 'Third',
	'CONTEST_STARTED'         => 'The contest started on %s.',
	'CONTEST_STARTS'          => 'The contest starts on %s.',
	'CONTEST_USERNAME'        => '<strong>Contest</strong>',
	'CONTEST_IMAGE_DESC'      => '<strong>Contest</strong> » The image-description is hidden, until the end of the contest on %s.',
	'CONTEST_WINNERS_OF'      => 'Победители в конкурса „%s“',
	'SEARCH_CONTEST'                    => 'Победители в конкурси',
	'VIEW_SEARCH_CONTESTS'  => 'Виж победителите в конкурсите',
	'CONTEST_STATUS' => 'Състояние на конкурса',
	'CONTEST_PHASE_UPCOMING' => 'Планиран',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Качването на изображения започва на %s.',
	'CONTEST_PHASE_UPLOAD' => 'Качването е отворено',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'Изображения могат да се качват до %s. Гласуването и коментарите все още не са достъпни.',
	'CONTEST_PHASE_RATING' => 'Гласуването е отворено',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Качването е приключило. Гласуването остава отворено до %s; коментарите ще бъдат достъпни след това.',
	'CONTEST_PHASE_FINISHED' => 'Приключил',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'Конкурсът приключи. Резултатите и коментарите вече са достъпни.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'Датите се показват във вашата часова зона: %s.',
]);
