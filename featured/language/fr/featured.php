<?php
/**
 * phpBB Gallery - Featured Images language.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'FEATURED_IMAGES' => 'Images à la une',
	'FEATURED_SETTINGS' => 'Images à la une et diaporama',
	'FEATURE_IMAGE' => 'Mettre l’image à la une',
	'UNFEATURE_IMAGE' => 'Retirer des images à la une',
	'FEATURED_IMAGE_ADDED' => 'L’image a été ajoutée à la sélection à la une.',
	'FEATURED_IMAGE_REMOVED' => 'L’image a été retirée de la sélection à la une.',
	'FEATURED_NOT_AUTHORISED' => 'Vous n’êtes pas autorisé à gérer les images à la une dans cet album.',
	'FEATURED_APPROVED_ONLY' => 'Seules les images approuvées peuvent être mises à la une.',
	'FEATURED_ENABLE' => 'Afficher les images à la une',
	'FEATURED_ENABLE_EXPLAIN' => 'Affiche sur l’index de la Galerie la sélection constituée par les modérateurs.',
	'FEATURED_COUNT' => 'Nombre d’images à la une',
	'FEATURED_COUNT_EXPLAIN' => 'Nombre d’images à la une visibles à afficher, de 1 à 20. Les permissions sont filtrées séparément pour chaque visiteur.',
	'FEATURED_SLIDESHOW' => 'Utiliser le diaporama',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Affiche une grande image à la une à la fois avec une navigation accessible. Si désactivé, la disposition en cartes configurée pour la Galerie est utilisée.',
	'FEATURED_AUTOPLAY' => 'Démarrer automatiquement le diaporama',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'La lecture automatique est désactivée pour les visiteurs demandant moins d’animations et peut toujours être mise en pause.',
	'FEATURED_INTERVAL' => 'Intervalle du diaporama',
	'FEATURED_INTERVAL_EXPLAIN' => 'Durée entre les changements automatiques, de 3 à 30 secondes.',
	'FEATURED_INCLUDE_PERSONAL' => 'Inclure les images des albums personnels',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Permet d’afficher des images sélectionnées provenant d’albums personnels lorsque le visiteur est autorisé à les voir.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Commandes des images à la une',
	'FEATURED_PREVIOUS' => 'Image à la une précédente',
	'FEATURED_NEXT' => 'Image à la une suivante',
	'FEATURED_PLAY' => 'Lire le diaporama',
	'FEATURED_PAUSE' => 'Mettre le diaporama en pause',
	'FEATURED_GO_TO' => 'Afficher l’image à la une %d',
	'GALLERY_CORE_NOT_FOUND' => 'Gallery Core 4.2.0 ou version ultérieure doit être installé et activé avant d’activer Images à la une.',
]);
