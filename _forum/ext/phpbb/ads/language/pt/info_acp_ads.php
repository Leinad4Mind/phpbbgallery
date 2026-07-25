<?php

/**
 *
 * Advertisement management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_PHPBB_ADS_TITLE'      => 'Gestão de Anúncios',
	'ACP_MANAGE_ADS_TITLE'     => 'Gerir anúncios',
	'ACP_ADS_SETTINGS_TITLE'   => 'Configurações',
	'ACP_PHPBB_ADS_ADD_LOG'    => '<strong>Anúncio adicionado</strong><br />» %s',
	'ACP_PHPBB_ADS_EDIT_LOG'   => '<strong>Anúncio editado</strong><br />» %s',
	'ACP_PHPBB_ADS_DELETE_LOG' => '<strong>Anúncio eliminado</strong><br />» %s',
]);
