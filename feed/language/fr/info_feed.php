<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
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
* Language for the gallery feed
*/
$lang = array_merge($lang, [
	'FEED'						=> 'Flux',
	'FEED_SETTINGS'				=> 'Réglages du flux',

	'FEED_ENABLED'				=> 'Activer le flux de la galerie',
	'FEED_ENABLED_EXPLAIN'		=> 'Si activé, la galerie publie un flux ATOM des images les plus récentes.',
	'FEED_ENABLED_PEGAS'		=> 'Inclure les galeries personnelles',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Si activé, les images des galeries personnelles peuvent également apparaître dans le flux. Les permissions d’album et de consultation sont toujours respectées.',
	'FEED_LIMIT'				=> 'Nombre d’éléments',
	'FEED_LIMIT_EXPLAIN'		=> 'Nombre maximal d’images publiées dans un flux.',

	'ALBUM_FEED'				=> 'Publier cet album dans le flux',
	'ALBUM_FEED_EXPLAIN'		=> 'Si désactivé, les images de cet album n’apparaissent jamais dans le flux de la galerie.',

	'NO_FEED'					=> 'Aucun flux n’est disponible pour cet album.',
	'NO_FEED_ENABLED'			=> 'Le flux de la galerie n’est pas activé sur ce forum.',

	'GALLERY_CORE_NOT_FOUND'	=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'L’extension a été activée avec succès.',
]);
