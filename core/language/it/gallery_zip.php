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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'L’archivio ZIP contiene una voce con un rapporto di compressione non sicuro.',
	'ZIP_DUPLICATE_PATH'              => 'L’archivio ZIP contiene percorsi di file duplicati.',
	'ZIP_EXTENSION_NOT_AVAILABLE'     => 'Il caricamento di archivi ZIP richiede l’estensione Zip di PHP.',
	'ZIP_EXTRACTION_FAILED'           => 'Non è stato possibile estrarre l’archivio ZIP in modo sicuro.',
	'ZIP_INVALID_ARCHIVE'             => 'L’archivio ZIP caricato non è valido o non può essere letto.',
	'ZIP_INVALID_IMAGE_TYPE'          => 'Il file “%s” nell’archivio ZIP non è un’immagine valida del tipo dichiarato.',
	'ZIP_NO_IMAGES'                   => 'L’archivio ZIP non contiene immagini consentite.',
	'ZIP_SIZE_LIMIT_EXCEEDED'         => 'L’archivio ZIP supera la dimensione di estrazione consentita.',
	'ZIP_TOO_MANY_ENTRIES'            => 'L’archivio ZIP contiene più di %d voci.',
	'ZIP_TOO_MANY_IMAGES'             => 'L’archivio ZIP contiene più di %d immagini consentite.',
	'ZIP_UNSAFE_PATH'                 => 'L’archivio ZIP contiene un percorso di file non sicuro.',
]);
