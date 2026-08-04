<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Версии изображений',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Настройка дополнительной истории замены и восстановления изображений.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Настройки версий',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Включить версии изображений',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Позволяет редакторам заменять файлы и восстанавливать сохранённые версии. Каждая версия занимает дополнительное место.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Сохранённых версий на изображение',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Выберите от 1 до 50. Старые файлы удаляются автоматически.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'Настройки версий изображений обновлены.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Версии изображений для этого альбома',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Каждая настройка может наследовать действующее значение ближайшего родительского альбома или глобальное значение.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Наследовать',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Действующая настройка: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Действующее значение: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Версии по альбомам',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Этот обзор только для чтения следует иерархии альбомов. Используйте Изменить для настройки альбома или подальбома.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Альбом',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Унаследовано',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Прямое значение',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Установлено: %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'В Галерее нет публичных альбомов.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Может управлять настройками версий изображений',
]);
