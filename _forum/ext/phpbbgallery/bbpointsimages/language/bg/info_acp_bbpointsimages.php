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
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Този преглед само за четене следва йерархията на Галерията. Редактирайте албум, за да промените преките му стойности; удебелените стойности са действащите.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Албум',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS_EXPLAIN' => 'Използвайте -1, за да наследите всяка числова стойност независимо от най-близкия настроен предшественик или глобалната настройка.',
	'ACP_BBPOINTSIMAGES_INHERIT' => 'Наследяване',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Използвайте -1 за наследяване от най-близкия настроен предшественик или от глобалната настройка.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_VALUE' => 'Действаща стойност: %1$d.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_TOGGLE' => 'Действаща настройка: %1$s.',
	'ACP_BBPOINTSIMAGES_INHERITED' => 'Наследено',
	'ACP_BBPOINTSIMAGES_DIRECT_VALUE' => 'Пряка стойност: %1$d',
	'ACP_BBPOINTSIMAGES_DIRECT_SETTING' => 'Пряка настройка',
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
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Разрешаване на сътрудници',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Позволява на авторите и редакторите на изображения да посочват сътрудници. Съществуващите сътрудници запазват признанието и своя дял от платените изтегляния, когато опцията е изключена.',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK' => 'Сътрудници във всички албуми',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_EXPLAIN' => 'Задава изричен избор за всички публични албуми или ги връща към наследяване на глобалната настройка. Изключенията за награда и цена се запазват.',
	'ACP_BBPOINTSIMAGES_INHERIT_GLOBAL' => 'Всички албуми да наследяват',
	'ACP_BBPOINTSIMAGES_ENABLE_ALL' => 'Включване във всички албуми',
	'ACP_BBPOINTSIMAGES_DISABLE_ALL' => 'Изключване във всички албуми',
	'ACP_BBPOINTSIMAGES_APPLY_ALL' => 'Прилагане към всички албуми',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_CONFIRM' => 'Сигурни ли сте, че искате да промените сътрудниците във всички публични албуми на Галерията?',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_SAVED' => 'Настройката за сътрудници е обновена за всички публични албуми на Галерията.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Сътрудници',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Въведете по едно регистрирано потребителско име на ред, до %1$d. Авторът на изображението се изключва автоматично.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'Тези сътрудници не са намерени или са неактивни: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'Едно изображение може да има най-много %1$d сътрудници.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD' => 'Награди за изображения в Галерията',
	'NOTIFICATION_BBPOINTSIMAGES_REWARD' => 'Получихте %1$d точки за публикуването на изображението <strong>%2$s</strong>.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE' => 'Продажби на оригинали от Галерията',
	'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE' => '%1$s купи оригиналния файл на <strong>%3$s</strong>; получихте %2$d точки.',
]);
