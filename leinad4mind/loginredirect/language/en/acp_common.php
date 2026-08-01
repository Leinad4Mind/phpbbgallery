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
	'NEW_VERSION' => 'New Version - %s',
	'NEW_VERSION_LINK' => 'Download here',
	'NO_VERSION_EXPLAIN' => 'Version update information is not available.',
	'VERSION' => 'Version',
));
