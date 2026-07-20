<?php

/**
 * @package sitesplat BBlinks for phpBB.
 * @copyright (c) 2017 SiteSplat All rights reserved
 * @license Proprietary
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
	'BBLINKS_MODAL_TITLE' => 'Detetado URL Externo',
	'BBLINKS_PROCEED'     => 'A conexão em que clicou é um URL externo. Tem a certeza e quer mesmo ser reencaminhado e avançar para o dito URL externo?',
	'BBLINKS_PROCEED_NO'  => 'Não',
	'BBLINKS_PROCEED_YES' => 'Sim',
]);
