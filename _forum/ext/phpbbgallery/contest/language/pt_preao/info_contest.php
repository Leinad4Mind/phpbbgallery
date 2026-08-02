<?php
/**
 * phpBB Gallery - Contest Add-on language.
 *
 * @package phpbbgallery/contest
 * @translation Leinad4Mind [Portuguese pre-AO90 [pt_preao]] (2026)
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
	'GALLERY_CORE_NOT_FOUND' => 'A extensão phpBB Gallery Core deve ser instalada e activada primeiro.',
	'EXTENSION_ENABLE_SUCCESS' => 'A extensão foi activada com sucesso.',
]);
