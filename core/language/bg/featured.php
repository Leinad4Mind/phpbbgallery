<?php
/**
 * phpBB Gallery - Featured Images language.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'FEATURED_IMAGES' => 'Избрани изображения',
	'FEATURED_SETTINGS' => 'Избрани изображения и слайдшоу',
	'FEATURE_IMAGE' => 'Добави към избраните',
	'UNFEATURE_IMAGE' => 'Премахни от избраните изображения',
	'FEATURED_IMAGE_ADDED' => 'Изображението беше добавено към избраната селекция.',
	'FEATURED_IMAGE_REMOVED' => 'Изображението беше премахнато от избраната селекция.',
	'FEATURED_NOT_AUTHORISED' => 'Нямате право да управлявате избрани изображения в този албум.',
	'FEATURED_APPROVED_ONLY' => 'Само одобрени изображения могат да бъдат избрани.',
	'FEATURED_ENABLE' => 'Показвай избрани изображения',
	'FEATURED_ENABLE_EXPLAIN' => 'Показва подбраната от модераторите селекция в началната страница на Галерията.',
	'FEATURED_LOCATION' => 'Показвай в',
	'FEATURED_LOCATION_EXPLAIN' => 'Изберете началната страница на Галерията, форума, и двете или нито една.',
	'FEATURED_LOCATION_NONE' => 'Нито една страница',
	'FEATURED_LOCATION_GALLERY' => 'Начална страница на Галерията',
	'FEATURED_LOCATION_FORUM' => 'Начална страница на форума',
	'FEATURED_LOCATION_BOTH' => 'И двете страници',
	'FEATURED_POSITION' => 'Позиция',
	'FEATURED_POSITION_EXPLAIN' => 'Поставя избраните изображения преди или след основното съдържание. Настройката се скрива, когато не е избрана страница.',
	'FEATURED_POSITION_TOP' => 'Горе',
	'FEATURED_POSITION_BOTTOM' => 'Долу',
	'FEATURED_COUNT' => 'Брой избрани изображения',
	'FEATURED_COUNT_EXPLAIN' => 'Брой видими избрани изображения за показване, от 1 до 20. Правата се проверяват отделно за всеки посетител.',
	'FEATURED_SLIDESHOW' => 'Използвай слайдшоу',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Показва по едно голямо избрано изображение с достъпна навигация. Когато е изключено, се използва настроеният картов изглед на Галерията.',
	'FEATURED_AUTOPLAY' => 'Стартирай слайдшоуто автоматично',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'Автоматичното възпроизвеждане е изключено за посетители, заявили намалено движение, и винаги може да бъде поставено на пауза.',
	'FEATURED_INTERVAL' => 'Интервал на слайдшоуто',
	'FEATURED_INTERVAL_EXPLAIN' => 'Време между автоматичните смени, от 3 до 30 секунди.',
	'FEATURED_INCLUDE_PERSONAL' => 'Включвай изображения от лични албуми',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Позволява показването на избрани изображения от лични албуми, когато посетителят има право да ги вижда.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Управление на избраните изображения',
	'FEATURED_PREVIOUS' => 'Предишно избрано изображение',
	'FEATURED_NEXT' => 'Следващо избрано изображение',
	'FEATURED_PLAY' => 'Пусни слайдшоуто',
	'FEATURED_PAUSE' => 'Пауза на слайдшоуто',
	'FEATURED_GO_TO' => 'Покажи избрано изображение %d',
	'GALLERY_CORE_NOT_FOUND' => 'Gallery Core 4.2.0 или по-нова версия трябва да бъде инсталирана и включена, преди да включите Избрани изображения.',
]);
