<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [German [de]] (2026)
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
	'ACP_GALLERY_EXPORT'			=> 'Galerie-Export',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Exportiert die Galeriebilder in ein ZIP-Archiv. Die Dateien tragen die Namen, die das Forum anzeigt, und sind nach ihren Alben gruppiert, sodass das Archiv lesbar ist – anders als die verschlüsselten Dateinamen auf der Festplatte. Dem Archiv wird ein Manifest mit allen Bildern beigelegt.',
]);
