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
	'GALLERY_CORE_NOT_FOUND'   => 'La extensión phpBB Gallery Core debe instalarse y activarse primero.',
	'EXTENSION_ENABLE_SUCCESS' => 'La extensión se ha activado correctamente.',
]);
