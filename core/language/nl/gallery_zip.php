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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'Het ZIP-archief bevat een item met een onveilige compressieverhouding.',
	'ZIP_DUPLICATE_PATH'             => 'Het ZIP-archief bevat dubbele bestandspaden.',
	'ZIP_EXTENSION_NOT_AVAILABLE'    => 'Voor het uploaden van ZIP-archieven is de PHP-extensie Zip vereist.',
	'ZIP_EXTRACTION_FAILED'          => 'Het ZIP-archief kon niet veilig worden uitgepakt.',
	'ZIP_INVALID_ARCHIVE'            => 'Het geüploade ZIP-archief is ongeldig of kan niet worden gelezen.',
	'ZIP_INVALID_IMAGE_TYPE'         => 'Het bestand “%s” in het ZIP-archief is geen geldige afbeelding van het opgegeven type.',
	'ZIP_NO_IMAGES'                  => 'Het ZIP-archief bevat geen toegestane afbeeldingen.',
	'ZIP_SIZE_LIMIT_EXCEEDED'        => 'Het ZIP-archief overschrijdt de toegestane uitpakgrootte.',
	'ZIP_TOO_MANY_ENTRIES'           => 'Het ZIP-archief bevat meer dan %d items.',
	'ZIP_TOO_MANY_IMAGES'            => 'Het ZIP-archief bevat meer dan %d toegestane afbeeldingen.',
	'ZIP_UNSAFE_PATH'                => 'Het ZIP-archief bevat een onveilig bestandspad.',
]);
