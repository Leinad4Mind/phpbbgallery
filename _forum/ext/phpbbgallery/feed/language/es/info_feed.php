<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Spanish [es]] (2026)
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
	'FEED'						=> 'Feed',
	'FEED_SETTINGS'				=> 'Ajustes del feed',

	'FEED_ENABLED'				=> 'Activar el feed de la galería',
	'FEED_ENABLED_EXPLAIN'		=> 'Si se activa, la galería publica un feed ATOM con las imágenes más recientes.',
	'FEED_ENABLED_PEGAS'		=> 'Incluir galerías personales',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Si se activa, las imágenes de las galerías personales también pueden aparecer en el feed. Los permisos de álbum y de visualización siempre se respetan.',
	'FEED_LIMIT'				=> 'Número de elementos',
	'FEED_LIMIT_EXPLAIN'		=> 'Número máximo de imágenes publicadas en un feed.',

	'ALBUM_FEED'				=> 'Publicar este álbum en el feed',
	'ALBUM_FEED_EXPLAIN'		=> 'Si se desactiva, las imágenes de este álbum nunca aparecen en el feed de la galería.',

	'NO_FEED'					=> 'No hay ningún feed disponible para este álbum.',
	'NO_FEED_ENABLED'			=> 'El feed de la galería no está activado en este foro.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Primero debe instalar y activar la extensión principal phpBB Gallery.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'La extensión se activó correctamente.',
]);
