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
	'GALLERY_CORE_NOT_FOUND'   => 'phpBB Gallery Core extension must be installed and enabled first.',
	'EXTENSION_ENABLE_SUCCESS' => 'The extension has been enabled successfully.',
]);
