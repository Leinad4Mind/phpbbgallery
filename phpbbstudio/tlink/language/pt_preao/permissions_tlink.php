<?php

/**
 * phpBB Studio - Topic links. An extension for the phpBB Forum Software package.
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
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

/**
 * Some characters you may want to copy&paste: ’ » “ ” …
 */
$lang = array_merge($lang, [
	'ACL_U_PHPBBSTUDIO_TLINK' => '<strong>Ligação do tópico</strong> - pode usar ligação do tópico',
]);
