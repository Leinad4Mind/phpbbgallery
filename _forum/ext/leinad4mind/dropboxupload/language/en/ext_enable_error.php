<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'EXT_PHP_ERROR' => 'This extension requires PHP %1$s or newer; the current version is %2$s.',
	'EXT_ENABLE_ERROR' => 'This extension requires phpBB from %1$s up to, but not including, %2$s; the current version is %3$s.',
	'EXT_AUTODB_ERROR' => 'Enable leinad4mind/autodbbackup before enabling this extension.',
));
