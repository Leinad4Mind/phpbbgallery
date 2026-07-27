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
	'GALLERY_CORE_NOT_FOUND'   => 'De phpBB Gallery Core-extensie moet eerst worden geïnstalleerd en ingeschakeld.',
	'EXTENSION_ENABLE_SUCCESS' => 'De extensie is succesvol ingeschakeld.',
]);
