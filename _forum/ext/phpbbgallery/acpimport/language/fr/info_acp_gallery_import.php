<?php
/**
 * phpBB Gallery - ACP Import Extension [French Translation]
 *
 * @package   phpbbgallery/acpimport
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_IMPORT_ALBUMS'         => 'Importer des images',
	'ACP_IMPORT_ALBUMS_EXPLAIN' => 'Vous pouvez importer ici des images à partir du système de fichier. Avant d’importer des images, n’oubliez pas de les redimensionner manuellement.',

	'IMPORT_ARCHIVES'            => 'Archives ZIP',
	'IMPORT_ARCHIVES_SELECT'     => 'Choisissez les archives à décompresser. Leurs images sont placées dans le dossier d’importation, où vous pourrez ensuite choisir celles à importer. Les archives décompressées sont supprimées.',
	'IMPORT_EXTRACT'             => 'Extraire',
	'IMPORT_NO_ARCHIVES'         => 'Il n’y a aucune archive ZIP dans le dossier d’importation.',
	'IMPORT_ZIP_ALL_EXTRACTED'   => '%1$d images ont été extraites de %2$d archives. Choisissez ci-dessous celles à importer.',
	'IMPORT_ZIP_EXTRACTED'       => '%1$d images extraites de « %2$s ».',
	'IMPORT_ZIP_FAILED'          => 'L’archive « %s » n’a pas pu être extraite.',
	'IMPORT_ZIP_MAX_IMAGES'      => 'Images par archive',
	'IMPORT_ZIP_MAX_IMAGES_EXPLAIN' => 'Combien d’images une seule archive peut fournir. Une archive n’est jamais lue au-delà de 1000 entrées, c’est donc aussi la valeur utile maximale.',
	'IMPORT_ZIP_SETTINGS'        => 'Archives ZIP',
	'IMPORT_ZIP_SETTINGS_SAVED'  => 'Les réglages des archives ont été enregistrés.',
	'IMPORT_ALBUM'               => 'Importer les images de l’album:',
	'IMPORT_DEBUG_MES'           => '%1$s images importées. Il y a encore %2$s images restantes.',
	'IMPORT_DIR_EMPTY'           => 'Le dossier %s est vide. Vous devez charger des images, avant de pouvoir les importer.',
	'IMPORT_FINISHED'            => 'Les %1$s images ont été importées avec succès.',
	'IMPORT_FINISHED_ERRORS'     => 'Les %1$s images ont été importées avec succès, mais les erreurs suivantes se sont produites :<br /><br />',
	'IMPORT_MISSING_ALBUM'       => 'Merci de sélectionner l’album où les images seront importées.',
	'IMPORT_SELECT'              => 'Choisissez les images que vous souhaitez importer. Les images chargées avec succès sont supprimées. Toutes les autres images sont encore disponibles.',
	'IMPORT_SCHEMA_CREATED'      => 'Le schéma d’importation a été créé avec succès. Merci de patienter pendant que les images sont importées.',
	'IMPORT_INVALID_IMAGE'       => 'Le fichier sélectionné « %s » n’est pas une image autorisée du dossier d’importation.',
	'IMPORT_SCHEMA_WRITE_FAILED' => 'L’état de l’importation n’a pas pu être enregistré de manière sécurisée.',
	'IMPORT_TOO_MANY_IMAGES'     => 'Vous pouvez importer au maximum %d images à la fois.',
	'IMPORT_UNREADABLE_FILES'    => '%d fichiers dont le nom est illisible ont été ignorés.',
	'IMPORT_USER'                => 'Chargées par',
	'IMPORT_USER_EXP'            => 'Vous pouvez charger des images d’un autre utilisateur.',
	'IMPORT_USERS_PEGA'          => 'Charger pour les utilisateurs de la galerie personnelle.',

	'MISSING_IMPORT_SCHEMA' => 'Le schéma d’importation spécifié (%s) n’a pas pu être trouvé.',

	'NO_FILE_SELECTED' => 'Vous devez sélectionner au moins un fichier.',

	'GALLERY_CORE_NOT_FOUND'   => 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
	'EXTENSION_ENABLE_SUCCESS' => 'L’extension a été activée avec succès.',
]);
