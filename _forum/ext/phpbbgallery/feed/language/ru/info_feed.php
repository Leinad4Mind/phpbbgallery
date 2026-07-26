<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Russian [ru]] (2026)
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
	'FEED'						=> 'Лента',
	'FEED_SETTINGS'				=> 'Настройки ленты',

	'FEED_ENABLED'				=> 'Включить ленту галереи',
	'FEED_ENABLED_EXPLAIN'		=> 'Если включено, галерея публикует ATOM-ленту с новейшими изображениями.',
	'FEED_ENABLED_PEGAS'		=> 'Включать личные галереи',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Если включено, изображения из личных галерей также могут появляться в ленте. Права доступа к альбомам и просмотру всегда соблюдаются.',
	'FEED_LIMIT'				=> 'Количество элементов',
	'FEED_LIMIT_EXPLAIN'		=> 'Максимальное количество изображений, публикуемых в одной ленте.',

	'ALBUM_FEED'				=> 'Публиковать этот альбом в ленте',
	'ALBUM_FEED_EXPLAIN'		=> 'Если отключено, изображения этого альбома никогда не появятся в ленте галереи.',

	'NO_FEED'					=> 'Для этого альбома лента недоступна.',
	'NO_FEED_ENABLED'			=> 'Лента галереи не включена на этом форуме.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'Расширение успешно включено.',
]);
