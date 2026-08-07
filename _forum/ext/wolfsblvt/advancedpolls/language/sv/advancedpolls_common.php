<?php
/**
 *
 * Advanced Polls [Swedish]
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
	'NOTIFICATION_AP_POLL_ENDED' => '<strong>Resultaten är synliga för omröstningen</strong>:',
	'NOTIFICATION_TYPE_AP_POLL_ENDED' => 'Resultaten är nu synliga för en omröstning där du har röstat',
	'NOTIFICATION_AP_POLL_OPTIONS_ADDED' => '<strong>Nya alternativ har lagts till i en omröstning där du har röstat</strong>:',
	'NOTIFICATION_TYPE_AP_POLL_OPTIONS_ADDED' => 'Nya alternativ läggs till i en omröstning där du har röstat',
	'LOG_AP_POLL_OPTIONS_ADDED' => 'Lade till %1$d alternativ i omröstningen i ämnet ”%2$s” utan att nollställa befintliga röster',
]);
