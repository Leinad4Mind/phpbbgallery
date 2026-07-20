<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'UCP_PHPBB_ADS_TITLE' => 'Os meus anúncios',
	'UCP_PHPBB_ADS_STATS' => 'Estatísticas',
]);
