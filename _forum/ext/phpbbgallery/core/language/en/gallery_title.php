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
	'GALLERY_TITLE'         => 'Gallery title',
	'GALLERY_TITLE_EXPLAIN' => 'The public name shown in the Gallery menu, breadcrumbs and page titles. Leave blank to use the translated default.',
]);
