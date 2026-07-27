<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Spanish [es]] (2026)
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
	'ACP_GALLERY_EXPORT'			=> 'Exportación de la galería',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Exporta las imágenes de la galería a un archivo ZIP. Los ficheros llevan los nombres que muestra el foro y se agrupan en sus álbumes, de modo que el archivo resulta legible, al contrario que los nombres cifrados guardados en el disco. Se añade al archivo un manifiesto con todas las imágenes.',
]);
