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
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'Необходимые расширения не включены: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints для изображений',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Настройте награды за публикацию в Галерее и стоимость доступа к исходным файлам.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Общие настройки',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Награда за одобренное изображение',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Баллы однократно начисляются конечному автору после одобрения. Укажите 0, чтобы отключить награды.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Стоимость исходного файла',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Баллы, необходимые для покупки доступа к исходному файлу. Укажите 0 для бесплатного доступа.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Исключения для альбомов',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Этот обзор только для чтения следует иерархии Галереи. Измените альбом, чтобы задать прямые значения; жирным показаны действующие значения.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Альбом',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS_EXPLAIN' => 'Укажите -1, чтобы каждое числовое значение независимо наследовалось от ближайшего настроенного предка или общей настройки.',
	'ACP_BBPOINTSIMAGES_INHERIT' => 'Наследовать',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Укажите -1, чтобы наследовать значение ближайшего настроенного предка или общую настройку.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_VALUE' => 'Действующее значение: %1$d.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_TOGGLE' => 'Действующая настройка: %1$s.',
	'ACP_BBPOINTSIMAGES_INHERITED' => 'Унаследовано',
	'ACP_BBPOINTSIMAGES_DIRECT_VALUE' => 'Прямое значение: %1$d',
	'ACP_BBPOINTSIMAGES_DIRECT_SETTING' => 'Прямая настройка',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'В Галерее нет доступных альбомов.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Настройки BBPoints для изображений сохранены.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Награды для существующих изображений',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Проверяет одобренные существующие изображения и начисляет настроенную награду. Существующие награды и полностью одинаковые файлы пропускаются.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Синхронизировать существующие награды',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Вы уверены, что хотите наградить все подходящие существующие изображения по текущим правилам альбомов?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'Синхронизация продолжается. Проверено %1$d изображений и начислено %2$d наград.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'Синхронизация завершена. Проверено %1$d изображений и начислено %2$d наград.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Для покупки исходного файла изображения необходимо войти.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Скачивание исходного файла изображения стоит %1$d баллов. Продолжить?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'У вас %1$d баллов, а для этого исходного файла требуется %2$d баллов.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'Сейчас исходный файл изображения нельзя приобрести.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Скачивания оригинала',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Разрешить назначение соавторов',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Позволяет авторам и редакторам изображений указывать соавторов. При отключении уже указанные соавторы сохраняют авторство и долю от платных скачиваний.',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK' => 'Соавторы во всех альбомах',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_EXPLAIN' => 'Задаёт явный выбор для всех общедоступных альбомов или возвращает их к наследованию общей настройки. Исключения наград и стоимости сохраняются.',
	'ACP_BBPOINTSIMAGES_INHERIT_GLOBAL' => 'Наследовать во всех альбомах',
	'ACP_BBPOINTSIMAGES_ENABLE_ALL' => 'Включить во всех альбомах',
	'ACP_BBPOINTSIMAGES_DISABLE_ALL' => 'Отключить во всех альбомах',
	'ACP_BBPOINTSIMAGES_APPLY_ALL' => 'Применить ко всем альбомам',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_CONFIRM' => 'Вы уверены, что хотите изменить назначение соавторов во всех общедоступных альбомах Галереи?',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_SAVED' => 'Назначение соавторов обновлено для всех общедоступных альбомов Галереи.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Соавторы',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Введите по одному зарегистрированному имени пользователя в строке, не более %1$d. Автор изображения исключается автоматически.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'Эти соавторы не найдены или неактивны: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'У изображения может быть не более %1$d соавторов.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD' => 'Награды за изображения Галереи',
	'NOTIFICATION_BBPOINTSIMAGES_REWARD' => 'Вы получили %1$d баллов за публикацию изображения <strong>%2$s</strong>.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE' => 'Продажи оригиналов Галереи',
	'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE' => '%1$s приобрёл оригинальный файл изображения <strong>%3$s</strong>; вы получили %2$d баллов.',
]);
