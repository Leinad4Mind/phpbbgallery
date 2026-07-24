<?php

/**
 * @package   Cron Status
 * @author    Igor Lavrov, John Peskens, Leinad4Mind
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_CRON_STATUS_TITLE'        => 'Статус Cron',
	'ACP_CRON_STATUS_CONFIG_TITLE' => 'Проверить Статус Cron',
	'CRONSTAT_NOTICE'              => '<div class="phpinfo"><p>This extension resides in %1$s » %2$s » %3$s.</p></div>',
	'CRONSTAT_UNLOCKED'            => 'Блокировка cron снята.',
]);

// Description of Cron Status extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Description',
	'DESCRIPTION_NOTICE' => 'Extension note',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Перечень заданий Cron (с сортировкой)',
			'DESCRIPTION_2' => 'Отображает статус каждого задания Cron',
			'DESCRIPTION_3' => 'Вы можете вручную выполнить любое готовое для выполнения задание',
			'DESCRIPTION_4' => 'Reset cronlock with a simple click',
		],
		'note' => [
			'NOTICE_1' => 'Уведомление о Статусе Cron (опционально)',
			'NOTICE_2' => 'Может быть выключено в разделе Настройки конференции',
			'NOTICE_3' => 'Switchable Run Cron Always',
			'NOTICE_4' => 'phpBB 3.2 ready',
		],
	],
]);
