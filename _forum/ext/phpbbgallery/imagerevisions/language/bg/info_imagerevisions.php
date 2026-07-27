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
	'GALLERY_CORE_NOT_FOUND'   => 'Разширението phpBB Gallery Core трябва първо да бъде инсталирано и включено.',
	'EXTENSION_ENABLE_SUCCESS' => 'Разширението беше включено успешно.',
]);
