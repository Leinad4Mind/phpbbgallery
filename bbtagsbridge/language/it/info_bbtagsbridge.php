<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Le seguenti estensioni obbligatorie non sono disponibili o sono disabilitate: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'L’estensione è stata attivata correttamente.',
]);
