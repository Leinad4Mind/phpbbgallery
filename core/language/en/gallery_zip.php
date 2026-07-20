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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'The ZIP archive contains an entry with an unsafe compression ratio.',
	'ZIP_DUPLICATE_PATH'              => 'The ZIP archive contains duplicate file paths.',
	'ZIP_EXTENSION_NOT_AVAILABLE'     => 'ZIP uploads require the PHP Zip extension.',
	'ZIP_EXTRACTION_FAILED'           => 'The ZIP archive could not be extracted safely.',
	'ZIP_INVALID_ARCHIVE'             => 'The uploaded ZIP archive is invalid or cannot be read.',
	'ZIP_INVALID_IMAGE_TYPE'          => 'The file “%s” in the ZIP archive is not a valid image of the declared type.',
	'ZIP_NO_IMAGES'                   => 'The ZIP archive does not contain any permitted images.',
	'ZIP_SIZE_LIMIT_EXCEEDED'         => 'The ZIP archive exceeds the permitted extraction size.',
	'ZIP_TOO_MANY_ENTRIES'            => 'The ZIP archive contains more than %d entries.',
	'ZIP_TOO_MANY_IMAGES'             => 'The ZIP archive contains more than %d permitted images.',
	'ZIP_UNSAFE_PATH'                 => 'The ZIP archive contains an unsafe file path.',
]);
