<?php

/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'WHOVISITEDTHISTOPIC_RETENTION_DAYS_EXPLAIN' => 'Exclui os dados de visitas mais antigos do que este número de dias. Defina 0 para mantê-los indefinidamente.',
	'WHOVISITEDTHISTOPIC_USERS_NOT_FOUND' => 'Os seguintes usuários não foram encontrados: %s',
	'WHOVISITEDTHISTOPIC_TOO_MANY_USERS' => 'É permitido no máximo %d usuários excluídos por lista.',
]);
