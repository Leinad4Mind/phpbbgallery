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
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Версии на изображенията за този албум',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Всяка настройка може да наследи ефективната стойност от най-близкия родителски албум или от глобалната настройка.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Наследяване',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Ефективна настройка: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Ефективна стойност: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Версии по албуми',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Този преглед само за четене следва йерархията на албумите. Използвайте Редактиране, за да промените албум или подалбум.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Албум',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Наследено',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Директна настройка',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Зададено на %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'Няма публични албуми в Галерията.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Може да управлява настройките за версии на изображенията',
]);
