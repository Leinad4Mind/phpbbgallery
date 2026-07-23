<?php

/**
 * @package Push Notifications for phpBB.
 * @copyright (c) 2017 - 2018 LavIgor
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
]);
