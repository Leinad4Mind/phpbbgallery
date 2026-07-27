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
	'GALLERY_TITLE'         => 'Galerietitel',
	'GALLERY_TITLE_EXPLAIN' => 'Der öffentliche Name im Galeriemenü, in der Navigation und in Seitentiteln. Leer lassen, um die übersetzte Vorgabe zu verwenden.',
]);
