<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
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
* Language for the Gallery favorites and UCP module
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Gestionar favoritos',
	'YOUR_FAVORITE_IMAGES'		=> 'Aquí puede ver las imágenes que ha marcado como favoritas. Puede eliminar las que ya no quiera conservar.',

	'FAVORITE_IMAGE'			=> 'Añadir a favoritos',
	'UNFAVORITE_IMAGE'			=> 'Quitar de favoritos',
	'FAVORITED_IMAGE'			=> 'La imagen se añadió a sus favoritos.',
	'UNFAVORITED_IMAGE'			=> 'La imagen se quitó de sus favoritos.',
	'UNFAVORITED_IMAGES'		=> 'Las imágenes se quitaron de sus favoritos.',

	'REMOVE_FROM_FAVORITES'		=> 'Quitar de favoritos',
	'NO_FAVORITES'				=> 'No tiene ningún favorito.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Elija una acción',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Ningún favorito',
		1	=> '%d favorito',
		2	=> '%d favoritos',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'No tiene permiso para marcar esta imagen como favorita.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Debe estar registrado e identificado para añadir imágenes a sus favoritos.',

	'WATCH_FAVO'				=> 'Suscribirme a las imágenes que marque como favoritas',
	'WATCH_FAVO_EXPLAIN'		=> 'Si se activa, al añadir una imagen a sus favoritos también se suscribirá a sus nuevos comentarios.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Primero debe instalar y activar la extensión principal phpBB Gallery.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'La extensión se activó correctamente.',
]);
