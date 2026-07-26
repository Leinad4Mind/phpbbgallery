<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Bulgarian [bg]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery feed
*/
$lang = array_merge($lang, [
	'FEED'						=> 'Емисия',
	'FEED_SETTINGS'				=> 'Настройки на емисията',

	'FEED_ENABLED'				=> 'Включване на емисията на галерията',
	'FEED_ENABLED_EXPLAIN'		=> 'Ако е включено, галерията публикува ATOM емисия с най-новите изображения.',
	'FEED_ENABLED_PEGAS'		=> 'Включване на личните галерии',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Ако е включено, изображенията от личните галерии също могат да се появяват в емисията. Правата за албуми и преглед винаги се спазват.',
	'FEED_LIMIT'				=> 'Брой елементи',
	'FEED_LIMIT_EXPLAIN'		=> 'Максимален брой изображения, публикувани в една емисия.',

	'ALBUM_FEED'				=> 'Публикуване на този албум в емисията',
	'ALBUM_FEED_EXPLAIN'		=> 'Ако е изключено, изображенията от този албум никога не се появяват в емисията на галерията.',

	'NO_FEED'					=> 'За този албум няма налична емисия.',
	'NO_FEED_ENABLED'			=> 'Емисията на галерията не е включена в този форум.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'Разширението е активирано успешно.',
]);
