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
	'GALLERY_TITLE_EXPLAIN' => 'O nome público exibido no menu, nos breadcrumbs e nos títulos das páginas da Galeria. Deixe em branco para usar a tradução padrão.',
]);
