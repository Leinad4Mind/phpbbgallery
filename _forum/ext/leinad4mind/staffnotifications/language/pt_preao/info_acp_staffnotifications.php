<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'STAFFNOTIFICATIONS_NOTIFICATIONS'         => 'Notificações da Equipa - Notificações',
	'STAFFNOTIFICATIONS_NOTIFICATIONS_EXPLAIN' => 'As notificações que devem ser enviadas aos utilizadores dos grupos selecionados abaixo.',
	'STAFFNOTIFICATIONS_GROUPS'                => 'Notificações da Equipa - Grupos',
	'STAFFNOTIFICATIONS_GROUPS_EXPLAIN'        => 'Os grupos que devem receber as notificações selecionadas acima.',
]);
