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
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Может управлять настройками версий изображений',
]);
