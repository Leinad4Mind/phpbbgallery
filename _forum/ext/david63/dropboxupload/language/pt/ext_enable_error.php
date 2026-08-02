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
	'EXT_PHP_ERROR' => 'Esta extensão requer PHP %1$s ou superior; a versão atual é %2$s.',
	'EXT_ENABLE_ERROR' => 'Esta extensão requer phpBB desde %1$s até antes de %2$s; a versão atual é %3$s.',
	'EXT_AUTODB_ERROR' => 'Ativa david63/autodbbackup antes desta extensão.',
));
