<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Die folgenden erforderlichen Erweiterungen sind nicht verfügbar oder nicht aktiviert: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Die Erweiterung wurde erfolgreich aktiviert.',
]);
