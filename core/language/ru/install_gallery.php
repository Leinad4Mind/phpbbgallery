<?php
/**
 * phpBB Gallery - ACP Core Extension [Russian Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator
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
	'GALLERY_CORE_ENABLE_IMAGE_BBCODE_FALLBACK' => 'phpBB Gallery Core включено. Существующий BBCode [image] сохранён, поскольку он относится к другому определению; галерея будет использовать [galleryimage] для новых изображений.',
	'GALLERY_CORE_ENABLE_ALBUM_BBCODE_FALLBACK' => 'phpBB Gallery Core включено. Существующий BBCode [album] сохранён, поскольку он относится к другому или устаревшему определению; галерея будет использовать [galleryalbum] для встроенных альбомов.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK_BOTH' => 'phpBB Gallery Core включено. Существующие BBCodes [image] и [album] сохранены; галерея будет использовать [galleryimage] для изображений и [galleryalbum] для встроенных альбомов.',
	'GALLERY_BBCODE_CONFLICT' => 'BBCode %s невозможно установить, поскольку этот тег принадлежит несовместимому пользовательскому BBCode. Переименуйте или удалите пользовательский BBCode и повторите попытку.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'BBCode %s невозможно установить, поскольку достигнут лимит BBCodes. Удалите один BBCode и повторите попытку.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core включено. Также доступны необязательные дополнения ACP Cleanup, ACP Import и EXIF.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core включено. Существующий BBCode [image] сохранён, поскольку он относится к другому определению; галерея будет использовать [galleryimage] для нового содержимого. [album] остаётся скрытым только для отображения старых сообщений и никогда не создаётся.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery невозможно включить. Отсутствуют обязательные компоненты: %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'Вы должны удалить расширение: <br /><strong>%s</strong><br /> перед удалением основного расширения.',
		2 => 'Вы должны удалить расширения: <br /><strong>%s</strong><br /> перед удалением основного расширения.',
	],
]);
