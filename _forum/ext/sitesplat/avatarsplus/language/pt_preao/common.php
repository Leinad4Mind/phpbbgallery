<?php

/**
 * @package BBavatar+ for phpBB.
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
	'ALLOW_MATERIAL'                 => 'Ativar avatares Material',
	'AVATAR_DRIVER_MATERIAL_TITLE'   => 'Avatar Material',
	'AVATAR_DRIVER_MATERIAL_EXPLAIN' => 'Cria um avatar tipo Gmail com o seu nome de utilizador.',
	'MATERIAL_SHAPE'                 => 'Forma do avatar',
	'MATERIAL_RANDOM'                => 'Aleatório',
	'MATERIAL_CIRCLE'                => 'Círculo',
	'MATERIAL_COLUMN'                => 'Coluna',
	'MATERIAL_DIAMOND'               => 'Diamante',
	'MATERIAL_RECTANGLE'             => 'Retângulo',
	'MATERIAL_RHOMB'                 => 'Losango',

	'ALLOW_GENERATOR'                 => 'Ativar Gerador de Avatares',
	'AVATAR_DRIVER_GENERATOR_TITLE'   => 'Gerador de Avatares',
	'AVATAR_DRIVER_GENERATOR_EXPLAIN' => 'Crie o seu próprio avatar.',

	'AVATARSPLUS_SHARE_TITLE'  => 'Ei sou euuu!',
	'AVATARSPLUS_SHARE_DESC'   => 'Acabei de criar este avatar super fixe com um incrível plugin do phpBB desenvolvido pelo SiteSplat! Vejam pessoal! https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat',
	'AVATARSPLUS_SHARE_CREDIT' => 'Criado com "BBavatar+" a partir do sitesplat.com',
]);
