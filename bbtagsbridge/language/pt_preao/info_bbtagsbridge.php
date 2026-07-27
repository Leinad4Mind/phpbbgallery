<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'As seguintes extensões obrigatórias não estão disponíveis ou estão desactivadas: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'A extensão foi activada com sucesso.',
]);
