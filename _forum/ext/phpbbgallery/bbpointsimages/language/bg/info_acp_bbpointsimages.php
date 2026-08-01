<?php
/**
 * phpBB Gallery - BBPoints Images
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'Необходимите разширения не са активирани: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints за изображения',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Настройте наградите за публикуване в Галерията и цената за достъп до оригиналните файлове.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Глобални настройки',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Награда за одобрено изображение',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Точки, начислени еднократно на крайния автор при одобряване. Задайте 0, за да изключите наградите.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Цена на оригиналния файл',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Точки, необходими за достъп до оригиналния файл. Задайте 0 за безплатен достъп.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Изключения по албуми',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Всяка стойност заменя независимо най-близкия предшественик. Използвайте -1 за наследяване.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Албум',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Използвайте -1 за наследяване от най-близкия настроен предшественик или от глобалната настройка.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Няма налични албуми в Галерията.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Настройките за BBPoints за изображения са запазени.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Награди за съществуващи изображения',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Проверява одобрените съществуващи изображения и начислява настроената награда. Съществуващите награди и напълно еднаквите файлове се пропускат.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Синхронизирай съществуващите награди',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Сигурни ли сте, че искате да наградите всички подходящи съществуващи изображения според текущите правила на албумите?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'Синхронизирането продължава. Досега са проверени %1$d изображения и са дадени %2$d награди.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'Синхронизирането завърши. Проверени са %1$d изображения и са дадени %2$d награди.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Трябва да влезете, за да купите този оригинален файл на изображението.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Изтеглянето на този оригинален файл струва %1$d точки. Искате ли да продължите?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'Имате %1$d точки, но този оригинален файл изисква %2$d точки.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'Оригиналният файл на изображението не може да бъде закупен в момента.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Изтегляния на оригинала',
]);
