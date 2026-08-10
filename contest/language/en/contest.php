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
	'CONTEST_RESULT_HIDDEN' => 'The rating for these images is hidden until the contest ends on %s.',
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
	'CONTEST_WINNERS_OF'      => 'Contest winners of “%s”',
	'SEARCH_CONTEST'                    => 'Contest winners',
	'VIEW_SEARCH_CONTESTS'  => 'View contest winners',
	'CONTEST_STATUS' => 'Contest status',
	'CONTEST_PHASE_UPCOMING' => 'Scheduled',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Submissions open on %s.',
	'CONTEST_PHASE_UPLOAD' => 'Submissions open',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'Images may be submitted until %s. Voting and comments are not available yet.',
	'CONTEST_PHASE_RATING' => 'Voting open',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Submissions are closed. Voting remains open until %s; comments open afterwards.',
	'CONTEST_PHASE_FINISHED' => 'Finished',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'The contest has ended. Results and comments are now available.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'Times are shown in your timezone: %s.',
]);
