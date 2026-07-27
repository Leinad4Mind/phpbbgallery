<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Dutch [nl]] (2026)
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
	'ACP_GALLERY_EXPORT'			=> 'Galerij-export',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Exporteert de afbeeldingen van de galerij naar een ZIP-archief. De bestanden krijgen de namen die het forum toont en worden per album gegroepeerd, waardoor het archief leesbaar is, anders dan de versleutelde bestandsnamen op schijf. Aan het archief wordt een manifest met alle afbeeldingen toegevoegd.',
]);
