<?php
/**
 * phpBB Gallery - ACP Core Extension [Russian Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'GALLERY_HELPLINE_ALBUM_EMBED'  => 'Альбом галереи: [album]ID_альбома[/album] встраивает в сообщение постраничный альбом с учётом прав доступа.',
	'GALLERY_HELPLINE_GALLERYALBUM' => 'Альбом галереи: [galleryalbum]ID_альбома[/galleryalbum], используется, когда [album] принадлежит другому или устаревшему BBCode.',
	'ACP_GALLERY_ALBUM_MANAGEMENT'       => 'Управление альбомом',
	'ACP_GALLERY_ALBUM_PERMISSIONS'      => 'Права доступа',
	'ACP_GALLERY_ALBUM_PERMISSIONS_COPY' => 'Копирование прав доступа',
	'ACP_VIEW_GALLERY_PERMISSIONS'       => 'Просмотр прав Галереи',
	'ACP_GALLERY_CONFIGURE_GALLERY'      => 'Настройка галереи',
	'ACP_GALLERY_LOGS'                   => 'Лог галереи',
	'ACP_GALLERY_LOGS_EXPLAIN'           => 'Список действий, выполненных в галерее, таких как одобрение, отклонение, блокировка и разблокировка, закрытие жалоб и удаление фотографий.',
	'ACP_GALLERY_MANAGE_ALBUMS'          => 'Управление альбомами',
	'ACP_GALLERY_OVERVIEW'               => 'Обзор',
	'GALLERY'                            => 'Галерея',
	'GALLERY_EXPLAIN'                    => 'Фотогалерея',
	'GALLERY_HELPLINE_IMAGE'             => 'Фото из галереи: [image]ID фото[/image]',
	'GALLERY_HELPLINE_GALLERYIMAGE'      => 'Фото из галереи: [galleryimage]ID фото[/galleryimage], используется, поскольку [image] принадлежит другому пользовательскому BBCode.',
	'GALLERY_HELPLINE_IMAGE_LEGACY'      => 'Фото из галереи: [album]ID фото[/album] (устаревший BBCode)',
	'GALLERY_POPUP'                      => 'Галерея',
	'GALLERY_POPUP_HELPLINE'             => 'Выбрать фото из галереи или загрузить новое',
	// Please do not change the copyright.
	'GALLERY_COPYRIGHT' => 'Powered by <a href="https://github.com/satanasov/phpbbgallery">phpBB Gallery</a> &copy; 2014–2026',

	// A little line where you can give yourself some credits on the translation.
	'GALLERY_TRANSLATION_INFO' => 'Русский перевод phpBB Gallery — <a href="http://www.phpbbguru.net/">www.phpbbguru.net</a>',
	'IMAGES'                   => 'Фото',
	'IMG_BUTTON_UPLOAD_IMAGE'  => 'Загрузка фото',
	'PERSONAL_ALBUM'           => 'Фотоальбом',
	'PHPBB_GALLERY'            => 'Галерея',
	'TOTAL_IMAGES_SPRINTF'     => [
		0 => 'Фотографий в галерее: <strong>0</strong>',
		1 => 'Фотографий в галерее: <strong>%d</strong>',
	],
]);
