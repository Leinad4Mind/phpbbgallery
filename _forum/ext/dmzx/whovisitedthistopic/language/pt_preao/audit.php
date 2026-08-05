<?php

/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'WHOVISITEDTHISTOPIC_TITLE_NO_COUNT' => 'Últimos <strong>%d</strong> membros que visitaram este tópico',
	'WHOVISITEDTHISTOPIC_RETENTION_DAYS' => 'Retenção das visitas',
	'WHOVISITEDTHISTOPIC_RETENTION_DAYS_EXPLAIN' => 'Apaga os dados de visitas mais antigos do que este número de dias. Define 0 para os conservar indefinidamente.',
	'WHOVISITEDTHISTOPIC_USERS_NOT_FOUND' => 'Não foram encontrados os seguintes utilizadores: %s',
	'WHOVISITEDTHISTOPIC_TOO_MANY_USERS' => 'É permitido um máximo de %d utilizadores excluídos por lista.',
]);
