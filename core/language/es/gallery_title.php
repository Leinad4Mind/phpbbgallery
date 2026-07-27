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
	'GALLERY_TITLE'         => 'Título de la galería',
	'GALLERY_TITLE_EXPLAIN' => 'El nombre público que aparece en el menú, las rutas de navegación y los títulos de página de la galería. Déjalo vacío para usar la traducción predeterminada.',
]);
