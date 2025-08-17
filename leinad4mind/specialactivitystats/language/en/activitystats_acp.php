<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 * DO NOT CHANGE
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
	'SPECIAL_ACTIVITY_STATS_INSTALLED'				=> 'Installed Version: v%s',

	'SPECIAL_ACTIVITY_STATS_TITLE'					=> 'Activity Stats',
	'SPECIAL_ACTIVITY_STATS_DISP_SET'				=> 'Display settings',
	'SPECIAL_ACTIVITY_STATS_OTHER'					=> 'Other settings',

	// acp form
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Show new topics',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Display the count of new topics',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Show new posts',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Display the count of new posts',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Show new users',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Display the count of new users',

	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'				=> 'Show bots',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Some user might wonder what bots are and fear them.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'			=> 'Show guests',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Display guests on the counter?',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'			=> 'Show hidden users',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Should hidden users be displayed in the list? (permission necessary)',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'				=> 'Show time',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'			=> 'All user see it or none. No special function for Admins.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Timeformat',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'				=> 'Display on hover',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'				=> 'Show user-ip',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'			=> 'Just for the users with administrative permissions, like on the viewonline.php',

	'SPECIAL_ACTIVITY_STATS_RECORD'					=> 'Record',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'				=> 'Display and save record',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Dateformat for the record',
	'SPECIAL_ACTIVITY_STATS_RESET'					=> 'Reset record',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'				=> 'Resets the time and counter of the Activity Stats record.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'				=> 'If you submit this form, the record will be reseted.',


	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Configuration updated successfully.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'				=> 'Sort users by',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'			=> 'In which order shall the user be displayed?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'				=> 'Username A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'				=> 'Username Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'				=> 'Time of visit ascending',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'				=> 'Time of visit descending',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'				=> 'User-ID ascending',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'				=> 'User-ID descending',

	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'				=> 'Cache time (seconds)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Duration in which the data is not re-calculated (improves performance)',

	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Check permissions',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'no=everybody should see the activity stats (ignore permission-settings); yes=use configured permissions (e.g. allow it for registered users only: ACP->permissions->global permissions -> group permissions -> registered users -> Advanced permissions -> Misc -> "Can see activity stats")',

	'SPECIAL_ACTIVITY_STATS_MODE'					=> 'Displaying users of ...',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'				=> 'Displaying users of today (since 00:00 board-timezone), or of the period set in the next option.',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'				=> 'Today',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'			=> 'Period of time',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'type 0, if you want to display the users of the last 24h',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'disabled, if you have choosen "today"',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'seconds',

]);
