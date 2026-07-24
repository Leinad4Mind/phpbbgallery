<?php

/**
 * @package   Cron Status
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_CRON_STATUS_TITLE'        => 'Cron Status',
	'ACP_CRON_STATUS_CONFIG_TITLE' => 'Check Cron Status',
	'CRONSTAT_NOTICE'              => '<div class="phpinfo"><p>This extension resides in %1$s » %2$s » %3$s.</p></div>',
	'CRONSTAT_UNLOCKED'            => 'Cron lock reset.',
]);

// Description of Cron Status extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Description',
	'DESCRIPTION_NOTICE' => 'Extension note',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Overview of Cron Jobs (with sorting)',
			'DESCRIPTION_2' => 'Displays the status of each Cron Task',
			'DESCRIPTION_3' => 'Run any ready task now, or run all of them at once',
			'DESCRIPTION_4' => 'Reset cron lock with a simple click',
		],
		'note' => [
			'NOTICE_1' => 'Cron Status Notice on main ACP page',
			'NOTICE_2' => 'Configurable in Board settings',
			'NOTICE_3' => 'Switchable Run Cron Always for bot traffic',
			'NOTICE_4' => 'phpBB 3.3 ready',
		],
	],
]);
