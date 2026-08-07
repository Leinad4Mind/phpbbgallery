<?php
/**
 *
 * Advanced Polls [English]
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
	'ADVANCEDPOLLS_EXT_NAME'				=> 'Advanced Polls',

// Viewtopic
	'AP_VOTES_HIDDEN'						=> 'Votes hidden',
	'AP_POLL_RUN_TILL_APPEND'				=> ', until then all votes are hidden.',
	'AP_VOTERS'								=> 'Voters',
	'AP_NONE'								=> 'None',
	'AP_DELETED_USER'					=> 'Deleted user',

	'AP_POLL_CANT_VOTE'						=> 'You can’t vote on this poll. Reason',
	'AP_POLL_REASON_NOT_POSTED'				=> 'You haven’t posted in this topic.',
	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Please note that if you vote, your vote will be visible.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Don’t vote, view results',
	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Please note that results are sorted by decreasing number of votes received.',
	'AP_POLL_TYPE_MISMATCH'					=> 'Inconsistent poll data, internal error.',
	'AP_VOTE_CHANGED'						=> 'You do not have permissions to change your casted votes.',
	'AP_TOO_MANY_VOTES'						=> 'You have tried to assign too many votes.',
	'AP_ABSTAINERS'							=> 'Chose not to vote',
	'AP_DELETE_VOTE'						=> 'Delete my vote',

	'AP_MAX_VOTES_SELECT'					=> [
		1	=> 'You may give up to <strong>%2$d</strong> votes to <strong>%1$d</strong> option',
		2	=> 'You may give up to <strong>%2$d</strong> votes amongst <strong>%1$d</strong> options',
	],
	'AP_GUEST_VOTES'						=> [
		1	=> '%d vote from guest',
		2	=> '%d votes from guests',
	],
	'AP_SCORE_TOTAL'						=> [
		1	=> '%d vote',
		2	=> '%d votes',
	],
	'AP_SCORE_BREAKDOWN'					=> 'Vote breakdown',
	'AP_SCORE_DISTRIBUTION_ENTRY'		=> [
		1	=> '%1$d vote of %2$d point',
		2	=> '%1$d votes of %2$d points',
	],
	'AP_RANK_TOTAL'						=> [
		1	=> '%d point',
		2	=> '%d points',
	],
	'AP_RANK_BREAKDOWN'					=> 'Ranking breakdown',
	'AP_RANK_DISTRIBUTION_ENTRY'			=> [
		1	=> '%1$d vote in position %2$d',
		2	=> '%1$d votes in position %2$d',
	],
	'AP_RANK_SELECT_EXACTLY'				=> [
		1	=> 'Select exactly %d option in order of preference.',
		2	=> 'Select exactly %d options in order of preference.',
	],
// Posting
	'AP_POLL_TYPE'							=> 'Poll type',
	'AP_POLL_TYPE_EXPLAIN'					=> 'Choose how users assign their votes or points.',
	'AP_POLL_TYPE_CHOICE'					=> 'Choice',
	'AP_POLL_TYPE_SCORING'					=> 'Numeric scoring',
	'AP_POLL_TYPE_RANKING'					=> 'Ordered ranking',
	'AP_POLL_VISIBILITY'					=> 'Result visibility',
	'AP_POLL_VISIBILITY_EXPLAIN'			=> 'Choose when aggregate poll results become visible.',
	'AP_VISIBILITY_PUBLIC'					=> 'Public — always show results',
	'AP_VISIBILITY_DEFAULT'					=> 'After first vote',
	'AP_VISIBILITY_VOTE_COMPLETED'			=> 'After all available votes are used',
	'AP_VISIBILITY_PRIVATE'					=> 'Private — only after the poll ends',
	'AP_POLL_VOTE_MODE'						=> 'Vote changes',
	'AP_POLL_VOTE_MODE_EXPLAIN'				=> 'Choose whether votes are final, may be submitted incrementally, or may be changed while the poll is open.',
	'AP_VOTE_MODE_NO_CHANGE'				=> 'No change',
	'AP_VOTE_MODE_INCREMENTAL'				=> 'Incremental voting',
	'AP_VOTE_MODE_CHANGE'					=> 'Allow changes',
	'AP_POLL_VOTES_HIDE'					=> 'Hide votes',
	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'If enabled votes will be hidden until the poll ends. This option only works if the poll has a specified end.',
	'AP_POLL_VOTERS_SHOW'					=> 'Show poll voters',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'If enabled voters will be shown to those people who have the permission. Note that voters still will be hidden if votes are hidden.',
	'AP_POLL_VOTERS_LIMIT'					=> 'Limit votes',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'If enabled users can only vote if they have posted in this topic already.',
	'AP_POLL_SHOW_ORDERED'					=> 'Show results ordered',
	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'When results are shown, these are ordered by descending number of votes received (highest voted first). Otherwise, poll option order is used.',
	'AP_POLL_COLLAPSIBLE'					=> 'Collapsible poll',
	'AP_POLL_COLLAPSIBLE_EXPLAIN'			=> 'Allow users to collapse and expand this poll.',
	'AP_COLLAPSE_POLL'						=> 'Collapse poll',
	'AP_EXPAND_POLL'						=> 'Expand poll',
	'AP_RUN_POLL'							=> 'Run poll',
	'AP_RUN_POLL_FOR'						=> 'for',
	'AP_RUN_POLL_UNTIL'						=> 'until',
	'AP_RUN_POLL_INDEFINITELY'				=> 'indefinitely',
	'AP_POLL_END'							=> 'Poll end',
	'AP_POLL_END_EXPLAIN'					=> 'Specify the date and time when the poll ends. If any of these fields is specified, it overrides the Poll Length. Date fields left empty default to the current Poll End date; hour fields left empty default to 0. If you want to revert back to using Poll Length, you will need to clean all these fields.',

	'AP_YYYY_MM_DD'							=> 'YYYY-MM-DD',
	'AP_HH_MM'								=> 'HH:MM',
	'AP_POLL_END_INVALID'					=> 'Specified date/time is invalid',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'The maximum votes for a single option cannot be more than the total votes to distribute amongs all options',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'The maximum options to vote cannot be more than the total votes to distribute amongs all options',

	'AP_POLL_MAX_VALUE'						=> 'Maximum votes',
	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'This is the maximum number of votes that a voter might give to a single option.',
	'AP_POLL_TOTAL_VALUE'					=> 'Total votes',
	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'This is the total number of votes that a voter might distribute amongst all options.',
	'AP_RANK_POINTS'						=> 'Points by position',
	'AP_RANK_POINTS_EXPLAIN'				=> 'Set a positive, decreasing point value for each ranked position. The number of positions is controlled by Maximum options per user.',
	'AP_RANK_POSITION'						=> 'Position %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'You can’t assign a number of votes greater than the maximum value allowed.',
	'AP_POLL_VALUES_INVALID'				=> 'The minimum score cannot exceed the maximum score; maximum options, maximum score and total score must be greater than zero.',
	'AP_RANK_POSITIONS_INVALID'				=> 'The number of ranked positions must be between 1 and the number of poll options.',
	'AP_RANK_POINTS_INCOMPLETE'				=> 'Define one point value for every ranked position.',
	'AP_RANK_POINTS_INVALID'				=> 'Every ranking point value must be between 1 and 999.',
	'AP_RANK_POINTS_ORDER'					=> 'Ranking point values must strictly decrease from first to last position.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED'		=> 'Incremental voting cannot be used with ordered ranking.',
	'AP_RANK_SELECTION_INCOMPLETE'			=> 'Select exactly the configured number of options in order of preference.',
	'AP_QUESTION'							=> 'Question',
	'AP_QUESTION_REQUIRED'					=> 'Required question',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN'	=> 'Require an answer to the first question before the complete ballot can be submitted.',
	'AP_APPEND_OPTIONS'						=> 'Add options without resetting votes',
	'AP_APPEND_OPTIONS_EXPLAIN'				=> 'Preserve every existing vote and append only the new options added at the end of a question’s option list.',
	'AP_APPEND_OPTIONS_WARNING'				=> 'Existing questions and options must not be renamed, removed or reordered. Vote changes must be allowed. Eligible previous registered voters will be notified according to the ACP setting and their notification preferences.',
	'AP_APPEND_INVALID'						=> 'Options cannot be appended safely to this poll.',
	'AP_APPEND_REQUIRES_CHANGES'			=> 'Allow vote changes before adding options without resetting existing votes.',
	'AP_APPEND_POLL_ENDED'					=> 'Options cannot be appended without resetting votes after the poll has ended.',
	'AP_APPEND_STRUCTURE_CHANGED'			=> 'Existing poll questions or options were changed. Restore the original definition and add new options only at the end.',
	'AP_APPEND_TOO_MANY'					=> 'The appended options exceed the configured maximum number of poll options.',
	'AP_APPEND_NONE'						=> 'No new poll options were added.',
	'AP_ADDITIONAL_QUESTIONS'				=> 'Additional question pages',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN'		=> 'Each page uses the same poll type, limits, points, visibility and vote-change rules. Enter one option per line.',
	'AP_ADD_QUESTION'						=> 'Add question',
	'AP_MULTI_INVALID'						=> 'The additional-question data is invalid.',
	'AP_MULTI_TOO_MANY'						=> 'A poll may contain at most 20 additional questions.',
	'AP_MULTI_CONTENT_INVALID'				=> 'Every additional question needs a title and enough valid options for the global poll limits.',
	'AP_REQUIRED_QUESTION_MISSING'			=> 'Answer this required question before continuing.',
	'AP_POLL_NAVIGATION'					=> 'Poll question navigation',
	'AP_POLL_MIN_VALUE' => 'Minimum score',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'This is the minimum score that a voter may assign to a selected option.',
	'AP_VOTE_OUTSIDE_RANGE' => 'Every assigned score must be between the configured minimum and maximum values.',
]);
