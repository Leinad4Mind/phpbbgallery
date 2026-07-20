<?php

/**
 * @package BBfront for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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
	'BBFRONT'   => 'Página Inicial',
	'FRONTPAGE' => 'Página inicial',
	'SLIDE_NOW' => 'Saiba Mais',
]);
