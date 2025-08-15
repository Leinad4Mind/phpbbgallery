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
	'LOG_TINIFY_ACCOUNT_PROBLEM'		=> '<strong>TinyPNG account problem</strong><br />» %s',
	'LOG_TINIFY_SOURCE_IMAGE_PROBLEM'	=> '<strong>Tinify source image problem</strong><br />» %s',

	'LOG_PHP_JPEG_PROBLEM'	=> '<strong>PHP optimization JPEG problem</strong><br />» %s',
	'LOG_PHP_PNG_PROBLEM'	=> '<strong>PHP optimization PNG problem</strong><br />» %s',
));
