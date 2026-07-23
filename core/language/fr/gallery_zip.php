<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'L’archive ZIP contient une entrée dont le taux de compression est dangereux.',
	'ZIP_DUPLICATE_PATH'             => 'L’archive ZIP contient des chemins de fichiers en double.',
	'ZIP_EXTENSION_NOT_AVAILABLE'    => 'L’envoi d’archives ZIP nécessite l’extension PHP Zip.',
	'ZIP_EXTRACTION_FAILED'          => 'L’archive ZIP n’a pas pu être extraite en toute sécurité.',
	'ZIP_INVALID_ARCHIVE'            => 'L’archive ZIP envoyée est invalide ou ne peut pas être lue.',
	'ZIP_INVALID_IMAGE_TYPE'         => 'Le fichier « %s » de l’archive ZIP n’est pas une image valide du type déclaré.',
	'ZIP_NO_IMAGES'                  => 'L’archive ZIP ne contient aucune image autorisée.',
	'ZIP_SIZE_LIMIT_EXCEEDED'        => 'L’archive ZIP dépasse la taille d’extraction autorisée.',
	'ZIP_TOO_MANY_ENTRIES'           => 'L’archive ZIP contient plus de %d entrées.',
	'ZIP_TOO_MANY_IMAGES'            => 'L’archive ZIP contient plus de %d images autorisées.',
	'ZIP_UNSAFE_PATH'                => 'L’archive ZIP contient un chemin de fichier non sécurisé.',
]);
