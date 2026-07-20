<?php

/**
 * @copyright (c) 2014-2020 Leinad4Mind, Feneck91, etc.
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
	'DEBRIDER_ENABLE_OPTION' => 'Ativar Debrider',
	'DEBRIDER_GENERATE'      => 'Gerar links premium',
	'DEBRIDER_GENERATING'    => 'A gerar',
	'DEBRIDER_NO_PERMISSION' => 'Sem permissões',
	'DEBRIDER_API_ERROR'     => 'Falha ao gerar URL. Por favor tente novamente.'
]);
