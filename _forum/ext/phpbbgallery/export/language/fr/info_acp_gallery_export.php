<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [French [fr]] (2026)
 */

/**
* @ignore
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
* Language for the gallery export ACP module
*/
$lang = array_merge($lang, [
	'ACP_GALLERY_EXPORT'			=> 'Exportation de la galerie',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Exporte les images de la galerie dans une archive ZIP. Les fichiers portent les noms affichés par le forum et sont regroupés dans leurs albums, ce qui rend l’archive lisible, contrairement aux noms chiffrés stockés sur le disque. Un manifeste listant toutes les images est ajouté à l’archive.',
]);
