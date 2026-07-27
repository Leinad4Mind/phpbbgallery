<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Italian [it]] (2026)
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
	'ACP_GALLERY_EXPORT'			=> 'Esportazione della galleria',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Esporta le immagini della galleria in un archivio ZIP. I file portano i nomi mostrati dal forum e sono raggruppati nei rispettivi album, così l’archivio è leggibile, al contrario dei nomi cifrati salvati su disco. All’archivio viene aggiunto un manifesto con l’elenco di tutte le immagini.',
]);
