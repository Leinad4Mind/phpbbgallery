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
	'GALLERY_TITLE'         => 'Titre de la galerie',
	'GALLERY_TITLE_EXPLAIN' => 'Le nom public affiché dans le menu, le fil d’Ariane et les titres de page de la galerie. Laissez ce champ vide pour utiliser la traduction par défaut.',
]);
