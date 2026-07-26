<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
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
* Language for the gallery favorites
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Управление избранным',
	'YOUR_FAVORITE_IMAGES'		=> 'Здесь вы можете посмотреть изображения, добавленные в избранное. Вы можете удалить те, которые больше не хотите хранить.',

	'FAVORITE_IMAGE'			=> 'Добавить в избранное',
	'UNFAVORITE_IMAGE'			=> 'Удалить из избранного',
	'FAVORITED_IMAGE'			=> 'Изображение добавлено в ваше избранное.',
	'UNFAVORITED_IMAGE'			=> 'Изображение удалено из вашего избранного.',
	'UNFAVORITED_IMAGES'		=> 'Изображения удалены из вашего избранного.',

	'REMOVE_FROM_FAVORITES'		=> 'Удалить из избранного',
	'NO_FAVORITES'				=> 'У вас нет избранных изображений.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Выберите действие',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Нет избранного',
		1	=> '%d изображение в избранном',
		2	=> '%d изображения в избранном',
		3	=> '%d изображений в избранном',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Вам не разрешено добавлять это изображение в избранное.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Чтобы добавлять изображения в избранное, необходимо зарегистрироваться и войти.',

	'WATCH_FAVO'				=> 'Подписываться на изображения, добавленные в избранное',
	'WATCH_FAVO_EXPLAIN'		=> 'Если включено, при добавлении изображения в избранное вы также будете получать уведомления о новых комментариях к нему.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'Расширение успешно включено.',
]);
