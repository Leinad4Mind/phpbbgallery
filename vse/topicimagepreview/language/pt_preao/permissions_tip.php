<?php

/**
 * Topic Image Preview. An extension for the phpBB Forum Software package.
 * @copyright (c) 2020, Matt Friedman
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

/**
 * DO NOT CHANGE
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
	'ACL_F_VSE_TIP' => 'Pode ver pré-visualizações de imagens nos tópicos',
]);
