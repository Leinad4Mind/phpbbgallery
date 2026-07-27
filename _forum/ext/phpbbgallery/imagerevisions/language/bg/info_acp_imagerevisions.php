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
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Версии на изображенията',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Настройване на незадължителната история за замяна и възстановяване на изображения.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Настройки на версиите',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Включване на версиите на изображенията',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Позволява на редакторите да заменят файлове и да възстановяват запазени версии. Всяка версия използва допълнително място.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Запазени версии за изображение',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Изберете от 1 до 50. По-старите файлове се изтриват автоматично.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'Настройките на версиите бяха обновени.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Може да управлява настройките за версии на изображенията',
]);
