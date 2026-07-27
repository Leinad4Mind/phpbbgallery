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
	'GALLERY_TITLE'         => 'Título da Galeria',
	'GALLERY_TITLE_EXPLAIN' => 'O nome público apresentado no menu, nos breadcrumbs e nos títulos das páginas da Galeria. Deixa em branco para usar a tradução predefinida.',
]);
