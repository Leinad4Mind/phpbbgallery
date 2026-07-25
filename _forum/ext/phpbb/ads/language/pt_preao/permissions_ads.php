<?php

/**
 *
 * Advertisement management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACL_U_PHPBB_ADS'   => 'Pode ver estatísticas de gestão dos próprios anúncios',
	'ACL_A_PHPBB_ADS_M' => 'Pode gerir anúncios do phpBB Advertisement',
	'ACL_A_PHPBB_ADS_S' => 'Pode gerir configurações do phpBB Advertisement',
]);
