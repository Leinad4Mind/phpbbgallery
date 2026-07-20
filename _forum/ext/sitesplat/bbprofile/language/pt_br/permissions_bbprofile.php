<?php

/**
 * BBbbprofile. An extension for the phpBB Forum Software package.
 * @copyright (c) 2016, SiteSplat
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
	'ACL_U_BBPROFILE' => 'Pode ver caixa BBprofile',
]);
