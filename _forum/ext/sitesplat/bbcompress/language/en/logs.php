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
	'LOG_KRAKEN_PROBLEM'	    		=> '<strong>Kraken account error</strong><br />» %s',

	'LOG_TINIFY_ACCOUNT_PROBLEM'		=> '<strong>TinyPNG account error</strong><br />» %s',
	'LOG_TINIFY_SOURCE_IMAGE_PROBLEM'	=> '<strong>Tinify source image error</strong><br />» %s',

	'LOG_PHP_JPEG_PROBLEM'				=> '<strong>PHP optimization JPEG error</strong><br />» %s',
	'LOG_PHP_PNG_PROBLEM'				=> '<strong>PHP optimization PNG error</strong><br />» %s',

	'LOG_IMAGEOPTIM_ARGUMENT_PROBLEM'	=> '<strong>ImageOptim argument error</strong><br />» %s',
	'LOG_IMAGEOPTIM_NETWORK_PROBLEM'	=> '<strong>ImageOptim network error</strong><br />» %s',
	'LOG_IMAGEOPTIM_NOT_FOUND_PROBLEM'	=> '<strong>ImageOptim did not find image error</strong><br />» %s',
	'LOG_IMAGEOPTIM_SERVER_PROBLEM'		=> '<strong>ImageOptim origin server error</strong><br />» %s',
));
