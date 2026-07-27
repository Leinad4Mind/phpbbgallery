<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Russian [ru]] (2026)
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
	'ACP_GALLERY_EXPORT'			=> 'Экспорт галереи',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Экспортирует изображения галереи в ZIP-архив. Файлы получают имена, которые показывает форум, и группируются по альбомам, поэтому архив читаем — в отличие от зашифрованных имён на диске. В архив добавляется манифест со списком всех изображений.',
]);
