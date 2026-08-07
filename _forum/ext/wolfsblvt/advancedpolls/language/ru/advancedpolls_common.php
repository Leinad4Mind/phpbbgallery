<?php
/**
 *
 * Advanced Polls [Russian]
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @author Translation by FomenkoAndrey (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1294503)
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
	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Доступны результаты опроса</strong>:',
	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Результаты опроса, в котором вы голосовали, стали открыты для просмотра',
	'NOTIFICATION_AP_POLL_OPTIONS_ADDED' => '<strong>В опрос, в котором вы голосовали, добавлены новые варианты</strong>:',
	'NOTIFICATION_TYPE_AP_POLL_OPTIONS_ADDED' => 'В опрос, в котором вы голосовали, добавляются новые варианты',
	'LOG_AP_POLL_OPTIONS_ADDED' => 'Добавлено вариантов: %1$d — в опрос темы «%2$s» без сброса существующих голосов',
]);
