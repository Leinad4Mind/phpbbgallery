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
	'ALBUM_TYPE_CONTEST'                  => 'Contest',
	'CONTEST_CREATION'                    => 'Allow new contests',
	'CONTEST_CREATION_EXPLAIN'            => 'Allows administrators to create new contest albums. Existing contests remain active and editable when this is disabled.',
	'CONTEST_CREATION_DISABLED'           => 'Creating new contest albums is disabled in the Gallery configuration.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'A Non-Contest-Album can not be turned into a Contest-Albums.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Contest-Albums can not be turned into a Non-Contest-Album.',
	'CONTEST_DATE_EXPLAIN'                => 'Please enter date in YYYY-MM-DD HH:MM format.',
	'CONTEST_END'                         => 'Contest end',
	'CONTEST_END_BEFORE_RATING'           => 'The contest-end must not be before the contest-rating-start.',
	'CONTEST_END_BEFORE_START'            => 'The contest-end must not be before the contest-start.',
	'CONTEST_END_EXPLAIN'                 => 'After the end of the contest, users can no longer rate images.',
	'CONTEST_END_INVALID'                 => 'Invalid contest-end (%s). Please enter date in YYYY-MM-DD HH:MM format.',
	'CONTEST_RATING'                      => 'Rating start',
	'CONTEST_RATING_BEFORE_START'         => 'The contest-rating-start must not be before the contest-start.',
	'CONTEST_RATING_EXPLAIN'              => 'After the “Rating start“, users can no longer upload images.',
	'CONTEST_RATING_INVALID'              => 'Invalid contest-rating-start (%s). Please enter date in YYYY-MM-DD HH:MM format.',
	'CONTEST_SETTINGS'                    => 'Contest settings',
	'CONTEST_START'                       => 'Contest start',
	'CONTEST_START_EXPLAIN'               => 'At the start of the contest, users are allowed to upload images.',
	'CONTEST_START_INVALID'               => 'Invalid contest-start (%s). Please enter date in YYYY-MM-DD HH:MM format.',
]);
