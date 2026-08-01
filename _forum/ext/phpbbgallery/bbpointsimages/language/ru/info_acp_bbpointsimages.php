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
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Каждое значение независимо заменяет ближайшего предка. Укажите -1 для наследования.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Альбом',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Укажите -1, чтобы наследовать значение ближайшего настроенного предка или общую настройку.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'В Галерее нет доступных альбомов.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Настройки BBPoints для изображений сохранены.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Награды для существующих изображений',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Проверяет одобренные существующие изображения и начисляет настроенную награду. Существующие награды и полностью одинаковые файлы пропускаются.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Синхронизировать существующие награды',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Вы уверены, что хотите наградить все подходящие существующие изображения по текущим правилам альбомов?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'Синхронизация продолжается. Проверено %1$d изображений и начислено %2$d наград.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'Синхронизация завершена. Проверено %1$d изображений и начислено %2$d наград.',
]);
