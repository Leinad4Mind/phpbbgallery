<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
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
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core отсутствует! Загрузите и установите его до этого расширения.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'Расширение успешно включено.',

	'EXPORT_SELECTION'				=> 'Что экспортировать',
	'EXPORT_ALBUMS'					=> 'Альбомы',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Выберите один или несколько альбомов. Удерживайте Ctrl, чтобы выбрать несколько.',
	'EXPORT_ALL_ALBUMS'				=> 'Экспортировать всю галерею, не учитывая выбор выше',
	'EXPORT_DELIVERY'				=> 'Куда попадёт архив',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Архив, оставленный на сервере, записывается в %s и никогда не удаляется автоматически, поэтому вы можете забрать его по FTP в любое время.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Предложить для скачивания',
	'EXPORT_DELIVERY_SERVER'		=> 'Оставить на сервере',
	'EXPORT_LIMITS'					=> 'Ограничения',
	'EXPORT_LIMITS_EXPLAIN'			=> 'Не более %1$d изображений и %2$s за один экспорт, по %3$d изображений за раз.',
	'EXPORT_START'					=> 'Начать экспорт',
	'EXPORT_CONTINUE'				=> 'Продолжить',
	'EXPORT_DOWNLOAD'				=> 'Скачать',

	'EXPORT_STARTED'				=> [
		1	=> 'Начат экспорт %d изображения.',
		2	=> 'Начат экспорт %d изображений.',
	],
	'EXPORT_PROGRESS'				=> 'Экспортировано %1$d из %2$d изображений…',
	'EXPORT_FINISHED'				=> [
		1	=> 'Экспорт завершён, обработано %d изображение.',
		2	=> 'Экспорт завершён, обработано %d изображений.',
	],

	'EXPORT_JOBS'					=> 'Экспорты',
	'EXPORT_NO_JOBS'				=> 'Экспортов пока нет.',
	'EXPORT_JOB_ARCHIVE'			=> 'Архив',
	'EXPORT_JOB_CREATED'			=> 'Начат',
	'EXPORT_JOB_PROGRESS'			=> 'Ход выполнения',
	'EXPORT_JOB_SIZE'				=> 'Размер',
	'EXPORT_JOB_ACTION'				=> 'Действие',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> 'Не удалось добавить %d изображение.',
		2	=> 'Не удалось добавить %d изображений.',
	],
	'EXPORT_JOB_DELETED'			=> 'Экспорт удалён.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Такого экспорта не существует или он принадлежит не вам.',
	'EXPORT_STATUS_READY'			=> 'Готов',
	'EXPORT_STATUS_RUNNING'			=> 'Выполняется',

	'EXPORT_UCP_EXPLAIN'			=> 'Здесь вы можете скачать загруженные вами изображения с теми именами, которые показывает галерея, а не с теми, под которыми они хранятся на диске. До %d изображений за один экспорт.',
	'EXPORT_UCP_DISABLED'			=> 'Администратор отключил экспорт собственных изображений.',

	'EXPORT_NO_IMAGES'				=> 'Нет изображений для экспорта.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Экспорт может охватывать не более %d изображений. Экспортируйте меньше альбомов за раз.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Размер экспорта не может превышать %s. Экспортируйте меньше альбомов за раз.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'На сервере недостаточно свободного места для этого экспорта.',
	'EXPORT_ARCHIVE_FAILED'			=> 'Не удалось записать архив.',
	'EXPORT_ARCHIVE_MISSING'		=> 'Архива этого экспорта больше нет на сервере.',
	'EXPORT_STATE_FAILED'			=> 'Не удалось сохранить состояние этого экспорта. Проверьте, доступен ли каталог экспорта для записи.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Изображение %1$d пропущено: файла «%2$s» нет на сервере.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Изображение %1$d пропущено: не удалось прочитать файл «%2$s».',
	'EXPORT_ERROR_ARCHIVE'			=> 'Не удалось записать архив «%s».',
]);
