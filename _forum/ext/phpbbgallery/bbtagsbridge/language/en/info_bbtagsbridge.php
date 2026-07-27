<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'The following required extensions are unavailable or disabled: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'The extension has been enabled successfully.',
]);
