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
	'EXT_ENABLE_ERROR' => 'O Login Redirect requer o phpBB %1$s ou superior e anterior a %2$s. Versão atual: %3$s.',
	'EXT_PHP_ERROR' => 'O Login Redirect requer o PHP %1$s ou superior. Versão atual: %2$s.',
));
