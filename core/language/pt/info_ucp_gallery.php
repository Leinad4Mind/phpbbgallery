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
	'UCP_GALLERY'                 => 'Galeria',
	'UCP_GALLERY_PERSONAL_ALBUMS' => 'Gerir álbuns pessoais',
	'UCP_GALLERY_SETTINGS'        => 'Configurações Pessoais',
	'UCP_GALLERY_WATCH'           => 'Gerir subscrições',
	'UCP_GALLERY_FAVORITES'       => 'Gerir Favoritos',
]);
