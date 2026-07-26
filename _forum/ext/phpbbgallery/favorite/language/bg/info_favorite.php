<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
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
* Language for the gallery favorites
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Управление на любимите',
	'YOUR_FAVORITE_IMAGES'		=> 'Тук можете да видите изображенията, които сте отбелязали като любими. Можете да премахнете тези, които вече не искате да запазите.',

	'FAVORITE_IMAGE'			=> 'Добавяне в любими',
	'UNFAVORITE_IMAGE'			=> 'Премахване от любими',
	'FAVORITED_IMAGE'			=> 'Изображението беше добавено в любимите ви.',
	'UNFAVORITED_IMAGE'			=> 'Изображението беше премахнато от любимите ви.',
	'UNFAVORITED_IMAGES'		=> 'Изображенията бяха премахнати от любимите ви.',

	'REMOVE_FROM_FAVORITES'		=> 'Премахване от любими',
	'NO_FAVORITES'				=> 'Нямате любими изображения.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Изберете действие',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Няма любими',
		1	=> '%d любимо',
		2	=> '%d любими',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Нямате право да добавите това изображение в любими.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Трябва да сте регистрирани и влезли, за да добавяте изображения в любими.',

	'WATCH_FAVO'				=> 'Абониране за изображенията, които добавям в любими',
	'WATCH_FAVO_EXPLAIN'		=> 'Ако е включено, при добавяне на изображение в любими ще получавате известия и за новите коментари към него.',

	'GALLERY_CORE_NOT_FOUND'	=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'Разширението е активирано успешно.',
]);
