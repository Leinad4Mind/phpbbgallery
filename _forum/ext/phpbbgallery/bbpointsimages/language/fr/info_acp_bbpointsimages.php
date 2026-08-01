<?php
/**
 * phpBB Gallery - BBPoints Images
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'Les extensions requises ne sont pas activées : %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints pour les images',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Configurer les récompenses de publication dans la Galerie et le coût d’accès aux fichiers originaux.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Paramètres globaux',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Récompense par image approuvée',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Points attribués une seule fois à l’auteur final lors de l’approbation. Utilisez 0 pour désactiver les récompenses.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Coût du fichier original',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Points requis pour acheter l’accès au fichier original. Utilisez 0 pour un accès gratuit.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Exceptions par album',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Chaque valeur remplace indépendamment celle de l’ancêtre le plus proche. Utilisez -1 pour hériter.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Utilisez -1 pour hériter de l’ancêtre configuré le plus proche ou du paramètre global.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Aucun album de la Galerie n’est disponible.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Les paramètres BBPoints pour les images ont été enregistrés.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Récompenses des images existantes',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Analyser les images existantes approuvées et attribuer la récompense configurée. Les récompenses existantes et les fichiers strictement identiques sont ignorés.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Synchroniser les récompenses existantes',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Voulez-vous vraiment récompenser toutes les images existantes admissibles selon les règles actuelles des albums ?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'La synchronisation continue. %1$d images analysées et %2$d récompenses attribuées jusqu’à présent.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'La synchronisation est terminée. %1$d images ont été analysées et %2$d récompenses attribuées.',
]);
