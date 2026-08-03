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
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core est absent ! Téléchargez-le et installez-le avant cette extension.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'L’extension a été activée avec succès.',

	'EXPORT_SELECTION'				=> 'Que faut-il exporter',
	'EXPORT_ALBUMS'					=> 'Albums',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Choisissez un ou plusieurs albums. Maintenez la touche Ctrl pour en sélectionner plusieurs.',
	'EXPORT_ALL_ALBUMS'				=> 'Exporter toute la galerie, en ignorant la sélection ci-dessus',
	'EXPORT_DELIVERY'				=> 'Destination de l’archive',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Une archive laissée sur le serveur est écrite dans %s et n’est jamais supprimée automatiquement, vous pouvez donc la récupérer par FTP quand vous le souhaitez.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'La proposer au téléchargement',
	'EXPORT_DELIVERY_SERVER'		=> 'La laisser sur le serveur',
	'EXPORT_LIMITS'					=> 'Limites',
	'EXPORT_LIMITS_EXPLAIN'			=> 'Au plus %1$d images et %2$s par exportation, écrites %3$d images à la fois.',
	'EXPORT_SETTINGS'				=> 'Paramètres d’exportation',
	'EXPORT_MAX_IMAGES'				=> 'Nombre maximal d’images par exportation',
	'EXPORT_MAX_IMAGES_EXPLAIN'		=> 'Nombre maximal d’images autorisé dans une exportation. La limite de sécurité est de %d.',
	'EXPORT_MAX_SIZE_MIB'			=> 'Taille maximale par exportation (Mio)',
	'EXPORT_MAX_SIZE_MIB_EXPLAIN'	=> 'Taille totale maximale des fichiers originaux. La limite de sécurité est de %d Mio.',
	'EXPORT_BATCH_SIZE'				=> 'Images par lot',
	'EXPORT_BATCH_SIZE_EXPLAIN'		=> 'Nombre d’images écrites par requête. Une valeur basse réduit la mémoire utilisée et les délais d’attente. La limite est de %d.',
	'EXPORT_SETTINGS_SAVED'			=> 'Les paramètres d’exportation ont été enregistrés.',
	'EXPORT_START'					=> 'Démarrer l’exportation',
	'EXPORT_CONTINUE'				=> 'Continuer',
	'EXPORT_DOWNLOAD'				=> 'Télécharger',

	'EXPORT_STARTED'				=> [
		1	=> 'L’exportation de %d image a commencé.',
		2	=> 'L’exportation de %d images a commencé.',
	],
	'EXPORT_PROGRESS'				=> '%1$d image(s) exportée(s) sur %2$d…',
	'EXPORT_FINISHED'				=> [
		1	=> 'L’exportation s’est terminée avec %d image.',
		2	=> 'L’exportation s’est terminée avec %d images.',
	],

	'EXPORT_JOBS'					=> 'Exportations',
	'EXPORT_NO_JOBS'				=> 'Il n’y a encore aucune exportation.',
	'EXPORT_JOB_ARCHIVE'			=> 'Archive',
	'EXPORT_JOB_CREATED'			=> 'Démarrée',
	'EXPORT_JOB_PROGRESS'			=> 'Progression',
	'EXPORT_JOB_SIZE'				=> 'Taille',
	'EXPORT_JOB_ACTION'				=> 'Action',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> '%d image n’a pas pu être ajoutée.',
		2	=> '%d images n’ont pas pu être ajoutées.',
	],
	'EXPORT_JOB_DELETED'			=> 'L’exportation a été supprimée.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Cette exportation n’existe pas ou ne vous appartient pas.',
	'EXPORT_STATUS_READY'			=> 'Prête',
	'EXPORT_STATUS_RUNNING'			=> 'En cours',

	'EXPORT_UCP_EXPLAIN'			=> 'Vous pouvez télécharger ici les images que vous avez envoyées, avec les noms affichés par la galerie plutôt que ceux sous lesquels elles sont stockées sur le disque. Jusqu’à %d images par exportation.',
	'EXPORT_UCP_DISABLED'			=> 'L’administrateur du forum a désactivé l’exportation de vos propres images.',

	'EXPORT_NO_IMAGES'				=> 'Il n’y a aucune image à exporter.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Une exportation peut couvrir au plus %d images. Exportez moins d’albums à la fois.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Une exportation peut occuper au plus %s. Exportez moins d’albums à la fois.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'Il n’y a pas assez d’espace libre sur le serveur pour cette exportation.',
	'EXPORT_ARCHIVE_FAILED'			=> 'L’archive n’a pas pu être écrite.',
	'EXPORT_ARCHIVE_MISSING'		=> 'L’archive de cette exportation n’est plus sur le serveur.',
	'EXPORT_STATE_FAILED'			=> 'L’état de cette exportation n’a pas pu être enregistré. Vérifiez que le répertoire d’exportation est accessible en écriture.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Image %1$d ignorée : le fichier « %2$s » n’est pas sur le serveur.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Image %1$d ignorée : le fichier « %2$s » n’a pas pu être lu.',
	'EXPORT_ERROR_ARCHIVE'			=> 'L’archive « %s » n’a pas pu être écrite.',
]);
