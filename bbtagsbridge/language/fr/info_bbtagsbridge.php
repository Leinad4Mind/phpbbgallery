<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Les extensions requises suivantes sont indisponibles ou désactivées : %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'L’extension a été activée avec succès.',
]);
