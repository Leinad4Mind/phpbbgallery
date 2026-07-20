<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_GALLERY'               => 'phpBB Galeria',
	'ACP_GALLERY_OVERVIEW'      => 'Visão Geral',
	'ACP_GALLERY_MANAGE_ALBUMS' => 'Gerir Álbuns',
	'ACP_GALLERY_CORE_SETTINGS' => 'Configurações Principais',
	'ACP_GALLERY_MANAGE_EXT'    => 'Gerir Extensões (phpBB Gallery)',
]);
