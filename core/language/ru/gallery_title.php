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
	'GALLERY_TITLE'         => 'Название галереи',
	'GALLERY_TITLE_EXPLAIN' => 'Публичное название в меню, навигационной цепочке и заголовках страниц галереи. Оставьте поле пустым, чтобы использовать перевод по умолчанию.',
]);
