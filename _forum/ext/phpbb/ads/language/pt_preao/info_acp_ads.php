<?php

/**
 * @copyright (c) 2024
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
	'ACP_PHPBB_ADS_TITLE'      => 'Gestão de Anúncios',
	'ACP_MANAGE_ADS_TITLE'     => 'Gerir anúncios',
	'ACP_ADS_SETTINGS_TITLE'   => 'Configurações',
	'ACP_PHPBB_ADS_ADD_LOG'    => '<strong>Anúncio adicionado</strong><br />» %s',
	'ACP_PHPBB_ADS_EDIT_LOG'   => '<strong>Anúncio editado</strong><br />» %s',
	'ACP_PHPBB_ADS_DELETE_LOG' => '<strong>Anúncio eliminado</strong><br />» %s',
]);
