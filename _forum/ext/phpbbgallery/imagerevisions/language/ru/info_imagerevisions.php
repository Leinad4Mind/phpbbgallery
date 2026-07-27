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
	'GALLERY_CORE_NOT_FOUND'   => 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
	'EXTENSION_ENABLE_SUCCESS' => 'Расширение успешно включено.',
]);
