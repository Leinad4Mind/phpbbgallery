<?php
/**
 * phpBB Gallery - ACP Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

/**
 * DO NOT CHANGE
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
	'GALLERY_BBCODE_CONFLICT' => 'The %s BBCode cannot be installed because that tag belongs to an incompatible custom BBCode. Rename or remove the custom BBCode, then try again.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'The %s BBCode cannot be installed because the BBCode limit has been reached. Remove a BBCode, then try again.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core has been enabled. Optional ACP Cleanup, ACP Import and EXIF add-ons are also available.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core has been enabled. The existing [image] BBCode was preserved because it belongs to another definition; the Gallery will use [galleryimage] for new content. [album] remains hidden only to render historical posts and is never generated.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery cannot be enabled. Required components are missing: %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'You must uninstall the extension: <br /><strong>%s</strong><br /> before uninstalling the core extension.',
		2 => 'You must uninstall the extensions: <br /><strong>%s</strong><br /> before uninstalling the core extension.',
	],
]);
