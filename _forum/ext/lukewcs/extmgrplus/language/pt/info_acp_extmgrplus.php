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
	'EXTMGRPLUS_NAV_TITLE'           => 'Extension Manager Plus',
	'EXTMGRPLUS_NAV_CONFIG'          => 'Gerir extensões - Configurações',
	'EXTMGRPLUS_LOG_EXT_DISABLE_ALL' => '<strong>Extension Manager Plus</strong><br>» %1$u de %2$u extensões desativadas',
	'EXTMGRPLUS_LOG_EXT_ENABLE_ALL'  => '<strong>Extension Manager Plus</strong><br>» %1$u de %2$u extensões ativadas',
	'EXTMGRPLUS_VERSION_STRING'      => 'v%s',
]);
