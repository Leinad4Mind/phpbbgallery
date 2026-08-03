<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
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
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'Липсва phpBB Gallery Core! Изтеглете го и го инсталирайте преди това разширение.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението беше включено успешно.',

	'EXPORT_SELECTION'				=> 'Какво да се изнесе',
	'EXPORT_ALBUMS'					=> 'Албуми',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Изберете един или повече албуми. Задръжте Ctrl, за да изберете няколко.',
	'EXPORT_ALL_ALBUMS'				=> 'Изнасяне на цялата галерия, без оглед на избора по-горе',
	'EXPORT_DELIVERY'				=> 'Къде да отиде архивът',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Архив, оставен на сървъра, се записва в %s и никога не се премахва автоматично, така че можете да го вземете по FTP когато пожелаете.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Предлагане за изтегляне',
	'EXPORT_DELIVERY_SERVER'		=> 'Оставяне на сървъра',
	'EXPORT_LIMITS'					=> 'Ограничения',
	'EXPORT_LIMITS_EXPLAIN'			=> 'Най-много %1$d изображения и %2$s на изнасяне, като се записват по %3$d изображения наведнъж.',
	'EXPORT_SETTINGS'				=> 'Настройки за експортиране',
	'EXPORT_MAX_IMAGES'				=> 'Максимален брой изображения за експорт',
	'EXPORT_MAX_IMAGES_EXPLAIN'		=> 'Максимален брой изображения в един експорт. Ограничението за безопасност е %d.',
	'EXPORT_MAX_SIZE_MIB'			=> 'Максимален размер на експорт (MiB)',
	'EXPORT_MAX_SIZE_MIB_EXPLAIN'	=> 'Максимален общ размер на оригиналните файлове. Ограничението за безопасност е %d MiB.',
	'EXPORT_BATCH_SIZE'				=> 'Изображения в пакет',
	'EXPORT_BATCH_SIZE_EXPLAIN'		=> 'Брой изображения, записвани при една заявка. По-ниските стойности намаляват паметта и риска от timeout. Ограничението е %d.',
	'EXPORT_SETTINGS_SAVED'			=> 'Настройките за експортиране са запазени.',
	'EXPORT_START'					=> 'Начало на изнасянето',
	'EXPORT_CONTINUE'				=> 'Продължаване',
	'EXPORT_DOWNLOAD'				=> 'Изтегляне',

	'EXPORT_STARTED'				=> [
		1	=> 'Започна изнасянето на %d изображение.',
		2	=> 'Започна изнасянето на %d изображения.',
	],
	'EXPORT_PROGRESS'				=> 'Изнесени %1$d от %2$d изображения…',
	'EXPORT_FINISHED'				=> [
		1	=> 'Изнасянето завърши с %d изображение.',
		2	=> 'Изнасянето завърши с %d изображения.',
	],

	'EXPORT_JOBS'					=> 'Изнасяния',
	'EXPORT_NO_JOBS'				=> 'Все още няма изнасяния.',
	'EXPORT_JOB_ARCHIVE'			=> 'Архив',
	'EXPORT_JOB_CREATED'			=> 'Започнато',
	'EXPORT_JOB_PROGRESS'			=> 'Напредък',
	'EXPORT_JOB_SIZE'				=> 'Размер',
	'EXPORT_JOB_ACTION'				=> 'Действие',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> '%d изображение не можа да бъде добавено.',
		2	=> '%d изображения не можаха да бъдат добавени.',
	],
	'EXPORT_JOB_DELETED'			=> 'Изнасянето беше изтрито.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Такова изнасяне не съществува или не е ваше.',
	'EXPORT_STATUS_READY'			=> 'Готово',
	'EXPORT_STATUS_RUNNING'			=> 'В ход',

	'EXPORT_UCP_EXPLAIN'			=> 'Тук можете да изтеглите изображенията, които сте качили, с имената, които галерията показва, вместо тези, с които са запазени на диска. До %d изображения на изнасяне.',
	'EXPORT_UCP_DISABLED'			=> 'Администраторът е изключил изнасянето на собствени изображения.',

	'EXPORT_NO_IMAGES'				=> 'Няма изображения за изнасяне.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Едно изнасяне може да обхване най-много %d изображения. Изнасяйте по-малко албуми наведнъж.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Едно изнасяне може да е най-много %s. Изнасяйте по-малко албуми наведнъж.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'На сървъра няма достатъчно свободно място за това изнасяне.',
	'EXPORT_ARCHIVE_FAILED'			=> 'Архивът не можа да бъде записан.',
	'EXPORT_ARCHIVE_MISSING'		=> 'Архивът на това изнасяне вече го няма на сървъра.',
	'EXPORT_STATE_FAILED'			=> 'Състоянието на това изнасяне не можа да бъде запазено. Проверете дали папката за изнасяне е достъпна за запис.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Изображение %1$d беше пропуснато: файлът „%2$s“ не е на сървъра.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Изображение %1$d беше пропуснато: файлът „%2$s“ не можа да бъде прочетен.',
	'EXPORT_ERROR_ARCHIVE'			=> 'Архивът „%s“ не можа да бъде записан.',
]);
