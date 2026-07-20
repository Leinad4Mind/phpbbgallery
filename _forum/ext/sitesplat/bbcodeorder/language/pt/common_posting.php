<?php

/**
 * BBcodeOrder+
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'BBCODE_B'        => 'Negrito',
	'BBCODE_I'        => 'Itálico',
	'BBCODE_U'        => 'Sublinhado',
	'BBCODE_L'        => 'Lista',
	'BBCODE_O'        => 'Lista Ordenada',
	'BBCODE_LISTITEM' => 'Item da Lista',
	'BBCODE_C'        => 'Código',
	'BBCODE_Q'        => 'Citação',
	'BBCODE_IMG'      => 'Imagem',
	'BBCODE_URL'      => 'URL',
	'BBCODE_FLASH'    => 'FLASH',
]);
