<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'EXT_ENABLE_ERROR' => 'Login Redirect requires phpBB %1$s or newer and earlier than %2$s. Current version: %3$s.',
	'EXT_PHP_ERROR' => 'Login Redirect requires PHP %1$s or newer. Current version: %2$s.',
));
