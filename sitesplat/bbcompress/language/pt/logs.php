<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'LOG_TINIFY_ACCOUNT_PROBLEM'		=> '<strong>Problema na Conta TinyPNG</strong><br />» %s',
	'LOG_TINIFY_SOURCE_IMAGE_PROBLEM'	=> '<strong>Problema ao comprimir imagem de origem</strong><br />» %s',

	'LOG_PHP_JPEG_PROBLEM'	=> '<strong>Optimização PHP com problema no JPEG</strong><br />» %s',
	'LOG_PHP_PNG_PROBLEM'	=> '<strong>Optimização PHP com problema no PNG</strong><br />» %s',
));
