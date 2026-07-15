<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens, Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	$lang = array();
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'CRON'								=> 'Cron',
	'CRON_LOCKED'						=> 'Cron Locked',
	'CRON_TIME_LOCKED'					=> 'Cron time locked',
	'ACP_CRON_STATUS_TITLE'				=> 'Cron Status',
	'ACP_CRON_STATUS_EXPLAIN'			=> 'Cron Status presents a overview of cron tasks in your board. A red marked task means a task which never started which has a<br />problem. A red lock means this task running now or, is locked by cron manager and blocks other tasks. Reset the cronlock by clicking on the lock or run all crons with one click. Run a ready to run task by click on run next to the taskname. Configure Cron Status in General » Board configuration » Board settings.',
	'CRON_STATUS_REFRESH'				=> 'Seconds for refresh',
	'CRON_TASK_LOCKED'					=> 'Cron task locked, unlock it!',
	'CRON_STATUS_READY_TASKS'			=> 'Tasks ready to run',
	'CRON_STATUS_NOT_READY_TASKS'		=> 'Not ready to run tasks',
	'CRON_STATUS_NEVER_STARTED_TASKS'	=> 'Never started tasks',
	'CRON_STATUS_NO_TASKS'				=> 'No available cron tasks',
	'CRON_STATUS_DATE_FORMAT'			=> 'Date format for Cron Status page',
	'CRON_STATUS_DATE_FORMAT_EXPLAIN'	=> 'The date format is the same as the PHP <code>date</code> function.',
	'CRON_STATUS_MAIN_NOTICE'			=> 'Notice on the ACP index page',
	'CRON_STATUS_MAIN_NOTICE_EXPLAIN'	=> 'Display Cron Status Notice on the ACP index page if Cron is locked.',
	'CRON_STATUS_RUN_ALWAYS'			=> 'Run cron always',
	'CRON_STATUS_RUN_ALWAYS_EXPLAIN'	=> 'Run cron jobs also triggered by bots. Works great for forums not that busy.',
	'CRON_TASK_NAME'					=> 'Task name',
	'CRON_TASK_DATE'					=> 'Planned / Last task date',
	'CRON_NEW_DATE'						=> 'Run / New task date',
	'CRON_TASK_NEVER_STARTED'			=> 'Never started',
	'CRON_TASK_AUTO'					=> 'Auto',
	'CRON_TASK_DATE_TIME'				=> 'Current date & time',
	'CRON_STATUS_ERROR'					=> 'Refresh error',
	'CRON_STATUS_TIMEOUT'				=> 'Refresh timeout',
	'CRON_STATUS_ERROR_EXPLAIN'			=> 'An error occurred during refreshing the page.',
	'CRON_TASK_RUN'						=> 'Run',
	'CRON_TASK_RUNNING'					=> 'Running...',
	'CRON_TASK_RUN_NOW'					=> 'Run now',
	'CRON_TASK_RUN_ALL'					=> 'Run all'
));