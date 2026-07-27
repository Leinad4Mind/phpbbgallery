<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Следующие обязательные расширения недоступны или отключены: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Расширение успешно включено.',
]);
