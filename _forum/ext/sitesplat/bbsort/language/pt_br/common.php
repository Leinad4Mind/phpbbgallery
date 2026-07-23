<?php

/**
 * BBsort. An extension for the phpBB Forum Software package.
 * @copyright (c) 2017, Sitesplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'DEMO_PAGE'  => 'Demo',
	'DEMO_HELLO' => 'Olá, %s!',
	'DEMO_GOODBYE' => 'Adeus, %s!',

	'ACP_DEMO'               => 'Configurações',
	'ACP_DEMO_GOODBYE'       => 'Deve dizer adeus?',
	'ACP_DEMO_SETTING_SAVED' => 'As configurações foram salvas com sucesso!',

	'ACME_DEMO_NOTIFICATION' => 'Notificação demo da Acme',

	'VIEWING_ACME_DEMO' => 'Vendo a Demo da Acme',
]);
