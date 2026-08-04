<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Révisions des images',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Configurez l’historique facultatif de remplacement et de restauration des images.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Paramètres des révisions',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Activer les révisions des images',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Permet aux éditeurs de remplacer les fichiers et de restaurer les versions conservées. Chaque révision utilise de l’espace supplémentaire.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Révisions conservées par image',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Choisissez de 1 à 50. Les fichiers les plus anciens sont supprimés automatiquement.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'Les paramètres des révisions ont été mis à jour.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Révisions d’images pour cet album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Chaque paramètre peut hériter de la valeur effective de l’album parent le plus proche ou de la valeur globale.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Hériter',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Paramètre effectif : %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Valeur effective : %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Révisions par album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Cet aperçu en lecture seule suit la hiérarchie des albums. Utilisez Modifier pour changer un album ou sous-album.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Album',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Hérité',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Paramètre direct',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Défini sur %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'Il n’existe aucun album public dans la Galerie.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Peut gérer les paramètres des révisions d’images',
]);
