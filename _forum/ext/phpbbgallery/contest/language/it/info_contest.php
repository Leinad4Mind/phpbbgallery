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
	'GALLERY_CORE_NOT_FOUND' => 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
	'EXTENSION_ENABLE_SUCCESS' => 'L\'estensione è stata abilitata con successo.',
]);
