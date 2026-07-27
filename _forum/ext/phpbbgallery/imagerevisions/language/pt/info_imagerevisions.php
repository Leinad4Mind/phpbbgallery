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
	'GALLERY_CORE_NOT_FOUND'   => 'A extensão phpBB Gallery Core tem de ser instalada e ativada primeiro.',
	'EXTENSION_ENABLE_SUCCESS' => 'A extensão foi ativada com sucesso.',
]);
