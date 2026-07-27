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
	'GALLERY_TITLE'         => 'Titolo della galleria',
	'GALLERY_TITLE_EXPLAIN' => 'Il nome pubblico mostrato nel menu, nel percorso di navigazione e nei titoli delle pagine della galleria. Lascia vuoto per usare la traduzione predefinita.',
]);
