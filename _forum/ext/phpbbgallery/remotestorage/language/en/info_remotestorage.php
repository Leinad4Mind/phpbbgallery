<?php
/**
 * phpBB Gallery - Remote Storage language
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND' => 'The phpBB Gallery Core extension is required.',
	'REMOTE_STORAGE_REQUIREMENTS_MISSING' => 'Remote Storage requires the HTTP client and SimpleXML components supplied with a supported phpBB installation.',
]);
