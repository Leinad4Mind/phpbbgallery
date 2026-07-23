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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'ZIP-архив содержит запись с небезопасным коэффициентом сжатия.',
	'ZIP_DUPLICATE_PATH'             => 'ZIP-архив содержит повторяющиеся пути к файлам.',
	'ZIP_EXTENSION_NOT_AVAILABLE'    => 'Для загрузки ZIP-архивов требуется расширение PHP Zip.',
	'ZIP_EXTRACTION_FAILED'          => 'Не удалось безопасно распаковать ZIP-архив.',
	'ZIP_INVALID_ARCHIVE'            => 'Загруженный ZIP-архив недействителен или не может быть прочитан.',
	'ZIP_INVALID_IMAGE_TYPE'         => 'Файл «%s» в ZIP-архиве не является допустимым изображением заявленного типа.',
	'ZIP_NO_IMAGES'                  => 'ZIP-архив не содержит разрешённых изображений.',
	'ZIP_SIZE_LIMIT_EXCEEDED'        => 'ZIP-архив превышает допустимый размер распаковки.',
	'ZIP_TOO_MANY_ENTRIES'           => 'ZIP-архив содержит более %d записей.',
	'ZIP_TOO_MANY_IMAGES'            => 'ZIP-архив содержит более %d разрешённых изображений.',
	'ZIP_UNSAFE_PATH'                => 'ZIP-архив содержит небезопасный путь к файлу.',
]);
