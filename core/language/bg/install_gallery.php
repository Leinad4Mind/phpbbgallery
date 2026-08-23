<?php
/**
 * phpBB Gallery - ACP Core Extension [Bulgarian Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator Lucifer <https://www.anavaro.com>
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
	'GALLERY_CORE_ENABLE_IMAGE_BBCODE_FALLBACK' => 'phpBB Gallery Core е активирано. Съществуващият BBCode [image] беше запазен, защото принадлежи на друга дефиниция; галерията ще използва [galleryimage] за нови изображения.',
	'GALLERY_CORE_ENABLE_ALBUM_BBCODE_FALLBACK' => 'phpBB Gallery Core е активирано. Съществуващият BBCode [album] беше запазен, защото принадлежи на друга или наследена дефиниция; галерията ще използва [galleryalbum] за вградени албуми.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK_BOTH' => 'phpBB Gallery Core е активирано. Съществуващите BBCodes [image] и [album] бяха запазени; галерията ще използва [galleryimage] за изображения и [galleryalbum] за вградени албуми.',
	'GALLERY_BBCODE_CONFLICT' => 'BBCode %s не може да бъде инсталиран, защото този таг принадлежи на несъвместим персонализиран BBCode. Преименувайте или премахнете персонализирания BBCode и опитайте отново.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'BBCode %s не може да бъде инсталиран, защото е достигнат лимитът за BBCode. Премахнете един BBCode и опитайте отново.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core е активирано. Налични са и незадължителните добавки ACP Cleanup, ACP Import и EXIF.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core е активирано. Съществуващият BBCode [image] беше запазен, защото принадлежи на друга дефиниция; галерията ще използва [galleryimage] за ново съдържание. [album] остава скрит само за показване на стари публикации и никога не се генерира.',
	'GALLERY_DEPENDENCY_VERSION_UNSUPPORTED' => 'Добавката не може да бъде активирана. Версиите на зависимостите са несъвместими: %s.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery не може да бъде активирано. Липсват задължителни компоненти: %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'Трябва да деинсталирате разширението: <br /><strong>%s</strong><br /> преди да деинсталирате основното разширение.',
		2 => 'Трябва да деинсталирате разширенията: <br /><strong>%s</strong><br /> преди да деинсталирате основното разширение.',
	],
]);
