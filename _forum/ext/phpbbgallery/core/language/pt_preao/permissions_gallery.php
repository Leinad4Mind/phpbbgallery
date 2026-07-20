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

// Adding the permissions
$lang = array_merge($lang, [
	'ACL_A_GALLERY_MANAGE' => 'Pode gerir as configurações da phpBB Galeria',
	'ACL_A_GALLERY_ALBUMS' => 'Pode adicionar/editar álbuns e permissões',
]);
