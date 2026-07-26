<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
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
	'GALLERY_SUB_EXT_UNINSTALL'      => [
		1 => 'Tem de desinstalar a extensão: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
		2 => 'Tem de desinstalar as extensões: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
	],
]);
