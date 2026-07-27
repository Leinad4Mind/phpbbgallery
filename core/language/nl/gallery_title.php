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
	'GALLERY_TITLE'         => 'Galerijtitel',
	'GALLERY_TITLE_EXPLAIN' => 'De openbare naam in het galerijmenu, de broodkruimelnavigatie en paginatitels. Laat dit leeg om de vertaalde standaardnaam te gebruiken.',
]);
