<?php

/**
 * @package sitesplat BBlinks for phpBB.
 * @copyright (c) 2017 SiteSplat All rights reserved
 * @license Proprietary
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
	'BBLINKS_MODAL_TITLE' => 'Detetado URL Externo',
	'BBLINKS_PROCEED'     => 'A ligação em que clicaste é um URL externo. Tens a certeza de que queres mesmo ser reencaminhado e avançar para o dito URL externo?',
	'BBLINKS_PROCEED_NO'  => 'Não',
	'BBLINKS_PROCEED_YES' => 'Sim',
]);
