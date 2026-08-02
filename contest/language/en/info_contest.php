<?php
/**
 * phpBB Gallery - Contest Add-on language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
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
	'GALLERY_CORE_NOT_FOUND' => 'phpBB Gallery Core must be installed and enabled first.',
	'EXTENSION_ENABLE_SUCCESS' => 'The extension was enabled successfully.',
]);
