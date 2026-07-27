<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Bulgarian [bg]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery export ACP module
*/
$lang = array_merge($lang, [
	'ACP_GALLERY_EXPORT'			=> 'Изнасяне на галерията',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Изнася изображенията от галерията в ZIP архив. Файловете носят имената, които форумът показва, и са групирани в албумите си, така че архивът е четим, за разлика от кодираните имена на диска. Към архива се добавя опис на всички изображения.',
]);
