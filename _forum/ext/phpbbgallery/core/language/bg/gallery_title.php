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
	'GALLERY_TITLE'         => 'Заглавие на галерията',
	'GALLERY_TITLE_EXPLAIN' => 'Публичното име в менюто, навигационната пътека и заглавията на страниците на галерията. Оставете празно, за да използвате превода по подразбиране.',
]);
