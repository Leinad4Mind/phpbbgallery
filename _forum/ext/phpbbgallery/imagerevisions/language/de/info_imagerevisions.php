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
	'GALLERY_CORE_NOT_FOUND'   => 'Die Erweiterung phpBB Gallery Core muss zuerst installiert und aktiviert werden.',
	'EXTENSION_ENABLE_SUCCESS' => 'Die Erweiterung wurde erfolgreich aktiviert.',
]);
