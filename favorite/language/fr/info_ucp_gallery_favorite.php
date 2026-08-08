<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
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
* Language for the Gallery favorites and UCP module
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Gérer les favoris',
	'YOUR_FAVORITE_IMAGES'		=> 'Vous trouverez ici les images que vous avez mises en favori. Vous pouvez retirer celles que vous ne souhaitez plus conserver.',

	'FAVORITE_IMAGE'			=> 'Ajouter aux favoris',
	'UNFAVORITE_IMAGE'			=> 'Retirer des favoris',
	'FAVORITED_IMAGE'			=> 'L’image a été ajoutée à vos favoris.',
	'UNFAVORITED_IMAGE'			=> 'L’image a été retirée de vos favoris.',
	'UNFAVORITED_IMAGES'		=> 'Les images ont été retirées de vos favoris.',

	'REMOVE_FROM_FAVORITES'		=> 'Retirer des favoris',
	'NO_FAVORITES'				=> 'Vous n’avez aucun favori.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Choisissez une action',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Aucun favori',
		1	=> '%d favori',
		2	=> '%d favoris',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Vous n’êtes pas autorisé à mettre cette image en favori.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Vous devez être inscrit et connecté pour ajouter des images à vos favoris.',

	'WATCH_FAVO'				=> 'S’abonner aux images que je mets en favori',
	'WATCH_FAVO_EXPLAIN'		=> 'Si activé, ajouter une image à vos favoris vous abonne également à ses nouveaux commentaires.',

	'GALLERY_CORE_NOT_FOUND'	=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'L’extension a été activée avec succès.',
]);
