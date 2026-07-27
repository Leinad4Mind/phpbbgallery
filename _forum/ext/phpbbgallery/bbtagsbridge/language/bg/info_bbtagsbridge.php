<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Следните задължителни разширения не са налични или активирани: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Разширението беше активирано успешно.',
]);
