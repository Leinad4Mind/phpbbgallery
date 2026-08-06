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
]);
