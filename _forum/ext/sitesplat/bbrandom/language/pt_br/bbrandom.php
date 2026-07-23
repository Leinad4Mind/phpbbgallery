<?php

/**
 * @package BBrandom for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'AVATAR_DRIVER_RGRAVATAR_TITLE'   => 'Gravatar Aleatório',
	'AVATAR_DRIVER_RGRAVATAR_EXPLAIN' => 'Esta opção permitirá o uso de um Gravatar Aleatório',
	'BBRANDOM_SITESPLAT'              => '<i class="icon fa fa-info-circle"></i> Extensão de Avatares Aleatórios por <a href="http://www.sitesplat.com" title="Professional Web Development"><strong>SiteSplat.com</strong></a> desenvolvida para os <a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="Professional Premium Themes"><strong>Temas da SiteSplat</strong></a>',
]);
