<?php

/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
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

$lang = array_merge($lang, [
	'WHOVISITEDTHISTOPIC_TITLE_NO_COUNT' => 'Last <strong>%d</strong> members who visited this topic',
	'WHOVISITEDTHISTOPIC_RETENTION_DAYS' => 'Visit retention',
	'WHOVISITEDTHISTOPIC_RETENTION_DAYS_EXPLAIN' => 'Delete visit data older than this number of days. Set to 0 to keep it indefinitely.',
	'WHOVISITEDTHISTOPIC_USERS_NOT_FOUND' => 'The following users could not be found: %s',
	'WHOVISITEDTHISTOPIC_TOO_MANY_USERS' => 'A maximum of %d excluded users is allowed per list.',
]);
