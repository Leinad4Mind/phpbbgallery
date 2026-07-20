<?php

/**
 * BBcompress
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'LOG_KRAKEN_PROBLEM' => '<strong>Erro na conta Kraken</strong><br />» %s',

	'LOG_TINIFY_ACCOUNT_PROBLEM'      => '<strong>Erro na conta TinyPNG</strong><br />» %s',
	'LOG_TINIFY_SOURCE_IMAGE_PROBLEM' => '<strong>Erro na imagem fonte Tinify</strong><br />» %s',

	'LOG_PHP_JPEG_PROBLEM' => '<strong>Erro na otimização PHP de JPEG</strong><br />» %s',
	'LOG_PHP_PNG_PROBLEM'  => '<strong>Erro na otimização PHP de PNG</strong><br />» %s',

	'LOG_IMAGEOPTIM_ARGUMENT_PROBLEM'  => '<strong>Erro no argumento ImageOptim</strong><br />» %s',
	'LOG_IMAGEOPTIM_NETWORK_PROBLEM'   => '<strong>Erro de rede ImageOptim</strong><br />» %s',
	'LOG_IMAGEOPTIM_NOT_FOUND_PROBLEM' => '<strong>O ImageOptim não encontrou a imagem</strong><br />» %s',
	'LOG_IMAGEOPTIM_SERVER_PROBLEM'    => '<strong>Erro no servidor de origem ImageOptim</strong><br />» %s',
]);
