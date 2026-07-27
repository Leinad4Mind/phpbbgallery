<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Las siguientes extensiones obligatorias no están disponibles o están desactivadas: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'La extensión se ha activado correctamente.',
]);
