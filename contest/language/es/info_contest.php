<?php
/**
 * phpBB Gallery - Contest Add-on language.
 *
 * @package phpbbgallery/contest
 * @license GPL-2.0-only
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
	'GALLERY_CORE_NOT_FOUND' => 'Primero debe instalar y activar la extensión principal phpBB Gallery.',
	'EXTENSION_ENABLE_SUCCESS' => 'La extensión se activó correctamente.',
]);
