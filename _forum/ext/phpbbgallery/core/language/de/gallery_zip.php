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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'Das ZIP-Archiv enthält einen Eintrag mit einem unsicheren Komprimierungsverhältnis.',
	'ZIP_DUPLICATE_PATH'              => 'Das ZIP-Archiv enthält doppelte Dateipfade.',
	'ZIP_EXTENSION_NOT_AVAILABLE'     => 'ZIP-Uploads erfordern die PHP-Erweiterung „Zip“.',
	'ZIP_EXTRACTION_FAILED'           => 'Das ZIP-Archiv konnte nicht sicher entpackt werden.',
	'ZIP_INVALID_ARCHIVE'             => 'Das hochgeladene ZIP-Archiv ist ungültig oder kann nicht gelesen werden.',
	'ZIP_INVALID_IMAGE_TYPE'          => 'Die Datei „%s“ im ZIP-Archiv ist kein gültiges Bild des angegebenen Typs.',
	'ZIP_NO_IMAGES'                   => 'Das ZIP-Archiv enthält keine zulässigen Bilder.',
	'ZIP_SIZE_LIMIT_EXCEEDED'         => 'Das ZIP-Archiv überschreitet die zulässige Entpackgröße.',
	'ZIP_TOO_MANY_ENTRIES'            => 'Das ZIP-Archiv enthält mehr als %d Einträge.',
	'ZIP_TOO_MANY_IMAGES'             => 'Das ZIP-Archiv enthält mehr als %d zulässige Bilder.',
	'ZIP_UNSAFE_PATH'                 => 'Das ZIP-Archiv enthält einen unsicheren Dateipfad.',
]);
