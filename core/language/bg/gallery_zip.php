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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'ZIP архивът съдържа запис с опасно съотношение на компресия.',
	'ZIP_DUPLICATE_PATH'              => 'ZIP архивът съдържа дублиращи се пътища към файлове.',
	'ZIP_EXTENSION_NOT_AVAILABLE'     => 'Качването на ZIP архиви изисква PHP разширението Zip.',
	'ZIP_EXTRACTION_FAILED'           => 'ZIP архивът не можа да бъде извлечен безопасно.',
	'ZIP_INVALID_ARCHIVE'             => 'Каченият ZIP архив е невалиден или не може да бъде прочетен.',
	'ZIP_INVALID_IMAGE_TYPE'          => 'Файлът „%s“ в ZIP архива не е валидно изображение от заявения тип.',
	'ZIP_NO_IMAGES'                   => 'ZIP архивът не съдържа разрешени изображения.',
	'ZIP_SIZE_LIMIT_EXCEEDED'         => 'ZIP архивът надвишава разрешения размер за извличане.',
	'ZIP_TOO_MANY_ENTRIES'            => 'ZIP архивът съдържа повече от %d записа.',
	'ZIP_TOO_MANY_IMAGES'             => 'ZIP архивът съдържа повече от %d разрешени изображения.',
	'ZIP_UNSAFE_PATH'                 => 'ZIP архивът съдържа опасен път към файл.',
]);
