<?php
/**
 *
 * Advanced Polls [Hebrew]
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
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
	'NOTIFICATION_AP_POLL_ENDED' => '<strong>תוצאות הסקר גלויות כעת</strong>:',
	'NOTIFICATION_TYPE_AP_POLL_ENDED' => 'התוצאות גלויות כעת בסקר שבו הצבעת',
	'NOTIFICATION_AP_POLL_OPTIONS_ADDED' => '<strong>אפשרויות חדשות נוספו לסקר שבו הצבעת</strong>:',
	'NOTIFICATION_TYPE_AP_POLL_OPTIONS_ADDED' => 'אפשרויות חדשות נוספות לסקר שבו הצבעת',
	'LOG_AP_POLL_OPTIONS_ADDED' => 'נוספו %1$d אפשרויות לסקר בנושא „%2$s” בלי לאפס הצבעות קיימות',
]);
