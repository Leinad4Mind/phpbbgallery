<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
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
	'ACP_GALLERY_EXPORT'			=> 'Gallery export',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Export the gallery images to a ZIP archive. Files are named the way the board shows them and grouped into their albums, so the archive is readable in a way the hashed filenames on disk are not. A manifest listing every image is added to the archive.',
]);
