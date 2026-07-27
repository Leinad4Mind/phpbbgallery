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
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Peut gérer les paramètres des révisions d’images',
]);
